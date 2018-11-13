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
	setInterval(updatePot,300000);														//check pot and stats every 5 min
	
	//Monitor Current Payout Address
	var domOpenMenu=document.getElementById('openMenu');
	var domCloseMenu=document.getElementById('closeMenu');
	var domMenu=document.getElementById('fund');
	var smallScreen=(window.getComputedStyle(domOpenMenu).display!="none");				//Check if small css file
	domOpenMenu.style.display="none";													//hide open menu button
	var wallet=false;																	//set that no valid payout wallet set yet
	var domWallet=document.getElementById('wallet');
	domWallet.addEventListener('change',function() {									//watch for changes to payout wallet
		var newAddress=domWallet.value.trim();											//remove any white space from address
		if (digibyte.Address.isValid(newAddress)) {										//check if valid legacy address
			wallet=newAddress;															//set payout address
			if (smallScreen) domCloseMenu.style.display="block";						//if small screen make close menu button visible
			domWallet.style.backgroundColor="#ffffff";									//set input field background to white
		} else {
			wallet=false;																//set that payout wallet is invalid
			domCloseMenu.display="none";												//hide close menu
			domWallet.style.backgroundColor="#ff3333";									//set input fields background to light red
		}
	});
	domCloseMenu.addEventListener('click',function() {									//listen for close menu click
		domMenu.style.display="none";													//hide menu
		domOpenMenu.style.display="block";												//show open menu button
	});
	domOpenMenu.addEventListener('click',function() {									//listen for open menu click
		domMenu.style.display="block";													//show menu
		domOpenMenu.style.display="none";												//hide open menu button
	});
	
	
	//generate temp wallet
	var fundP,fundA,
		brainString="",
		domQR=document.getElementById('fundAddress');
	for (var i=0;i<3;i++) {
		var part=bip39.english[Math.floor(Math.random()*2048)];							//pick a random word from list
		brainString+=part.charAt(0).toUpperCase()+part.slice(1);						//make first letter upper case and add to string
	}
	var domRecovery=document.getElementById('recovery');
	domRecovery.value=brainString;														//set recovery phrase
	function makeBrain() {
		//compute path
		var hash=bitcoinjs.bitcoin.crypto.sha256(domRecovery.value);					//hash recovery phrase
		var path="m/13'";																//start path
		for (var i=0;i<16;i+=4) path+="/"+((hash[i+3]&0x7f)<<24|hash[i+2]<<16|hash[i+1]<<8|hash[i])+"'";//add first 4x 32bit part to path
		
		//compute key pair
		var xprv='xprv9s21ZrQH143K31Jh4aY1efbnvR3nwBPmGesTahvKVdV5r7a4JDLQ5t31taNtq7sN94o6bCdzLYXhehMLjXE5rpmEqysMV8YWiJuNTLombsx';	//set a hd private key to use
																								//This is random key.  Even though the key is public  
																								//funds are safe because there are 2^124-1 possible wallet
																								//and under normal circumstances funds will only be in address
																								//for less then 1 minute.  Would take centuries to try all
																								//combinations.
		var keyPair=bip39.getHDKeyFromXPrv(xprv,path).keyPair;							//generate key pair
		fundA=keyPair.getAddress("D");													//calculate address
		fundP=keyPair.toWIF();															//calculate private key
		
		//show address
		domQR.src=DigiQR.request(fundA,1,240,6,1);										//generate qr code
		document.getElementById('payAddress').innerHTML=fundA;							//show address
	}
	makeBrain();																		//generate intial address
	domRecovery.addEventListener('change',function() {									//wait for change in recovery phrase
		document.getElementById('payAddress').innerHTML='Please Wait';					//show message to let others know qr is bad
		setTimeout(makeBrain,10);														//short delay so ui can catch up then make brain wallet
	});
	var recoveryDelay=setTimeout(makeBrain,10);											//prevents an error
	domRecovery.addEventListener('keyup',function() {									//wait for key to be released
		document.getElementById('payAddress').innerHTML='Please Wait';					//show message to let others know qr is bad
		clearInterval(recoveryDelay);													//stop the last timer
		recoveryDelay=setTimeout(makeBrain,500);										//start timer so we dont kill processor while user is typing
	});
	domQR.addEventListener('click',function() {											//wait for qr code clicks
		window.open('digibyte:'+fundA);													//open users wallet
	});
	
	
	
	
	
	
	
	//Monitor Funding
	var fundF=false;
	var openFundWindow=function() {
		openWindow('buy');
		fundF=true;
	};
	document.getElementById('addFunds').addEventListener('click',openFundWindow);
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