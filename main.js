(function(undefined) {
	const FOLDER='api/';
	const SPRITE_SIZE=32;
	const SPRITE_HALF=SPRITE_SIZE/2;
	const SPRITE_TIME=5000;		//minimum time sprite is shown
	const SPRITE_FINISH=55000;	//time win or lose shows
	var guessLeft=0;
	

			
	const MAX_REQUESTS=4;													//max number of concurent requests to explorer server
	var digibyte=require('digibyte');										//load digibyte object.  should check digibyte.min.js has not been edited since last confirmation of good standing
	
	
	
		
/*_          ___           _                  _____           _                 
 \ \        / (_)         | |                / ____|         | |                
  \ \  /\  / / _ _ __   __| | _____      __ | (___  _   _ ___| |_ ___ _ __ ___  
   \ \/  \/ / | | '_ \ / _` |/ _ \ \ /\ / /  \___ \| | | / __| __/ _ \ '_ ` _ \ 
    \  /\  /  | | | | | (_| | (_) \ V  V /   ____) | |_| \__ \ ||  __/ | | | | |
     \/  \/   |_|_| |_|\__,_|\___/ \_/\_/   |_____/ \__, |___/\__\___|_| |_| |_|
                                                     __/ |                      
                                                    |___/ 
*/
	var domShadow=document['getElementById']('shadow');
	var closeWindows=function(shadow) {
		var windows=document['getElementsByClassName']('window');				//get all windows
		for (var i=0; i<windows['length']; i++) {								//go through each window
			windows[i]['style']['display']='none';								//make window invisible
		}
		if (shadow===true) domShadow['style']['display']='none';				//close shadow if set
		fundF=false;
	}
	var openWindow=function(windowType) {
		closeWindows();															//close all windows
		document['getElementById']("window_"+windowType)['style']['display']='block';//open the window associated with button pressed
		domShadow['style']['display']='block';									//open shadow
	}
	var domClose=document.getElementsByClassName("close");				//get all dom items using class next
	for (var i=0; i<domClose.length; i++) {								//go through each dom element with class "next"
		domClose[i].addEventListener('click', function() {closeWindows(true)}, false);			//attach click listener to execute closeWindows function
	}
	
	var error=function(message,nonrecoverable){
		nonrecoverable=nonrecoverable||false;
		document.getElementById('errorMessage').innerHTML=message;
		//document.getElementById('errorClose').style.display=nonrecoverable?'none':'block';
		openWindow('error');
	};
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//Handle requests
	xmr.setMax(MAX_REQUESTS);
	xmr.setServer(FOLDER);
	
	var oddsData=[];
	var redrawStats=function() {	
		var started=false;
		var start=false,end=false;
		var odds=1024;
		for (var i in oddsData) {
			if ((i!=0) && (oddsData[i]>0) && (start===false)) start=Math.floor(i/10)*10;
			odds-=oddsData[i];
			if (odds==0) {
				end=i;
				break;
			}			
		}
		end=Math.ceil(i/10)*10;
		odds=1024-oddsData[0];
		var values=[];
		var labels=[];
		for (var i=start;i<=end;i++) {
			odds-=oddsData[i];
			labels.push(i/10);
			values.push(((oddsData[i]==0)&&(i!=start))?null:odds/10.24);
		}
		new Chartist.Line(document.getElementById('oddsGraph'), {
			series:	[values],
			labels:	labels
		},{
			fullWidth: true,
			axisX:	{
				//type:		Chartist.AutoScaleAxis,
				divisor:	5,
				labelInterpolationFnc: function(value) {
					if (Math.floor(value)!=value) return;
					return Math.pow(10,value)/100000000 + " DGB";
				}
			},
			axisY: {
				offset: 	40,
				divisor:	10,		
				labelInterpolationFnc: function(value) {
					return value + "%";
				}
			},
			lineSmooth: Chartist.Interpolation.cardinal({
				fillHoles: 	true,
				tension:	0.2
			}),
			showPoint:		false,
			height:		"80%"
		});		
	}
	var updatePotSuccess=false;
	var oddsLinkObjects=document.getElementsByClassName('oddsLink');
	for (var i=0;i<oddsLinkObjects.length;i++) {
		oddsLinkObjects[i].addEventListener('click',function(){
			if (updatePotSuccess) {
				openWindow('graph');
				redrawStats();
			} else {
				error('Odd of winning stats not yet loaded');			
			}
		});
	}
	
	//check pot
	var updatePot=function() {
		xmr.getJSON("stats.php").then(function(data) {
			updatePotSuccess=true;
			
			//set top bar value
			document.getElementById('pot').innerHTML=data.pot.toFixed(2)+ " DGB";
			
			//set info bar
			var odds=0;
			for (var i in data.odds) {
				if (i>0) odds+=data.odds[i];
			}
			odds/=10.24;
			document.getElementById('infoPot').innerHTML=data.pot.toFixed(2)+ " DGB";
			document.getElementById('infoOdds').innerHTML=odds.toFixed(2)+ "%";
			document.getElementById('infoBig').innerHTML=data.jackpot.value.toFixed(2)+ " DGB";
			
			//set odds graph	
			oddsData=data.odds;
			redrawStats();
		});
	};
	updatePot();
	setInterval(updatePot,300000);
	
	//Monitor Current Payout Address
	var domOpenMenu=document.getElementById('openMenu');
	var domCloseMenu=document.getElementById('closeMenu');
	var domMenu=document.getElementById('fund');
	var smallScreen=(window.getComputedStyle(domOpenMenu).display!="none");
	domOpenMenu.style.display="none";
	var wallet=false;
	var domWallet=document.getElementById('wallet');
	domWallet.addEventListener('change',function() {
		var newAddress=domWallet.value.trim();
		if (digibyte.Address.isValid(newAddress)) {
			wallet=newAddress;
			if (smallScreen) domCloseMenu.style.display="block";
			domWallet.style.backgroundColor="#ffffff";
		} else {
			wallet=false;
			domCloseMenu.display="none";
			domWallet.style.backgroundColor="#ff3333";			
		}
	});
	domCloseMenu.addEventListener('click',function() {
		domMenu.style.display="none";
		domOpenMenu.style.display="block";
	});
	domOpenMenu.addEventListener('click',function() {
		domMenu.style.display="block";
		domOpenMenu.style.display="none";
	});
	
	//Monitor Funding
	var fundF=false;
	var openFundWindow=function() {
		openWindow('buy');
		fundF=true;
	};
	document.getElementById('addFunds').addEventListener('click',openFundWindow);
	var fundP=new digibyte.PrivateKey();
	var fundA=fundP.toAddress().toString();
	document.getElementById('payAddress').innerHTML=fundA;
	fundP=fundP.toWIF();
	console.log('Private Key:',fundP);
	
	var domQR=document.getElementById('fundAddress');
	domQR.src=DigiQR.request(fundA,1,240,6,1);
	domQR.addEventListener('click',function() {
		window.open('digibyte:'+fundA);
	});
	var skipFundCount=0;
	setInterval(function() {if ((fundF)||((!fundF)&&(++skipFundCount==30))) {
		skipFundCount=0;
		fundF=false;
		xmr.getJSON("fund.php?pkey="+fundP+"&address="+fundA).then(function(guesses) {	
			skipFundCount=0;
			fundF=true;
		
			//store added guesses
			if (guessLeft!=guesses) {
				guessLeft=guesses;
				document.getElementById('guess').innerHTML=guessLeft;
			
				//close window
				closeWindows(true);
			}
		},function() {
			error("<p>There was an error trying to check balance of temp wallet.  This may not be a problem but if you sent DigiByte and it did not make it to the game you can sweep funds back to your wallet with information below.</p><p>Your recovery private key is:<br>"+fundP+"</p>");
		});
	}},10000);
	
	//Handle Guesses
	var win=0;
	var domSearch=document.getElementById('search');
	var domSprite=document.getElementById('sprite');
	domSearch.addEventListener('click',function(e) {
		if (guessLeft>0) {
			if (wallet!=false) {
				document.getElementById('guess').innerHTML=--guessLeft;
				
				//start sprite
				var sCanvas = document.createElement("CANVAS");
				document.body.appendChild(sCanvas);
				sCanvas.style.position = "fixed";
				sCanvas.style.left = (e.clientX-SPRITE_HALF)+'px';
				sCanvas.style.top = (e.clientY-SPRITE_HALF)+'px';
				sCanvas.style.width = SPRITE_SIZE+'px';
				sCanvas.style.height = SPRITE_SIZE+'px';
				sCanvas.width=SPRITE_SIZE;
				sCanvas.height=SPRITE_SIZE;
				var ctx=sCanvas.getContext("2d");
				function drawFrame(i) {
					ctx.clearRect(0,0,SPRITE_SIZE,SPRITE_SIZE);
					ctx.drawImage(domSprite,SPRITE_SIZE*i,0,SPRITE_SIZE,SPRITE_SIZE,0,0,SPRITE_SIZE,SPRITE_SIZE);
				}
				var endTime=Date.now()+SPRITE_TIME;
				var done=0;
				var patern=[0,1,2,3,4,3,2,1,0,0];
				var paternI=0;
				drawFrame(0);
				var timer=setInterval(function(){
					paternI++;
					paternI%=patern.length;
					if ((done==0) || (Date.now()<endTime)) {
						drawFrame(patern[paternI]);
					} else {
						drawFrame(5.5-done/2);
						clearInterval(timer);
						setTimeout(function() {
							document.body.removeChild(sCanvas);
						},SPRITE_FINISH);
					}
				},100);
						

				//check if won
				xmr.getJSON("check.php?wallet="+wallet+"&x="+e.offsetX+"&y="+e.offsetY).then(function(amount) {
					if (amount>0) {
						//get balance
						win+=amount;
						document.getElementById('win').innerHTML=win.toFixed(8);
						document.getElementById('infoWin').innerHTML=win.toFixed(8);
						done=1;
					} else {
						done=-1;
					}
				});
			} else {
				openWindow('setWallet');
			}
		} else {
			openFundWindow();
		}
	},true);
	
	//open fund window
	openFundWindow();
})();