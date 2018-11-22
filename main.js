(function(undefined) {
	const SITE='DMw9wz6KHsvbvXsmo1Q8BajWcohYwjqwoq';									//game makers wallet
	const FOLDER='https://digger.digibyte.rocks/';										//api folder location
	const SPRITE_SIZE=32;																//size of sprite
	const SPRITE_HALF=SPRITE_SIZE/2;													//half the size of sprite
	const SPRITE_TIME=5000;																//minimum time sprite is shown
	const SPRITE_FINISH=55000;															//time win or lose shows
	var guessLeft=0;																	//initial number of guesses.  Should always be 0 but during testing with fake folder speeds up to change to 100
	

			
	const MAX_REQUESTS=4;																//max number of concurent requests to explorer server
	var digibyte=require('digibyte');													//load digibyte object.  should check digibyte.min.js has not been edited since last confirmation of good standing
	
	
	
		
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
		var windows=document['getElementsByClassName']('window');						//get all windows
		for (var i=0; i<windows['length']; i++) {										//go through each window
			windows[i]['style']['display']='none';										//make window invisible
		}
		if (shadow===true) domShadow['style']['display']='none';						//close shadow if set
		fundF=false;
	}
	var openWindow=function(windowType) {
		closeWindows();																	//close all windows
		document['getElementById']("window_"+windowType)['style']['display']='block';	//open the window associated with button pressed
		domShadow['style']['display']='block';											//open shadow
	}
	var domClose=document.getElementsByClassName("close");								//get all dom items using class next
	for (var i=0; i<domClose.length; i++) {												//go through each dom element with class "next"
		domClose[i].addEventListener('click', function() {closeWindows(true)}, false);	//attach click listener to execute closeWindows function
	}
	
	var error=function(message){														//error handling function
		document.getElementById('errorMessage').innerHTML=message;						//set error message
		openWindow('error');															//show error window
	};
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//Handle requests
	xmr.setMax(MAX_REQUESTS);															//set max number of transactions at a time
	xmr.setServer(FOLDER);																//set server folder

/* ____      _     _              __  __          ___             _             
  / __ \    | |   | |            / _| \ \        / (_)           (_)            
 | |  | | __| | __| |___    ___ | |_   \ \  /\  / / _ _ __  _ __  _ _ __   __ _ 
 | |  | |/ _` |/ _` / __|  / _ \|  _|   \ \/  \/ / | | '_ \| '_ \| | '_ \ / _` |
 | |__| | (_| | (_| \__ \ | (_) | |      \  /\  /  | | | | | | | | | | | | (_| |
  \____/ \__,_|\__,_|___/  \___/|_|       \/  \/   |_|_| |_|_| |_|_|_| |_|\__, |
                                                                           __/ |
                                                                          |___/
*/
	var oddsData=[];																	//odds data is logarithmic scale.
																						//number of addresses with at least but not more then next
																						//[0,10^0.1,10^0.2,10^0.3,10^0.4,...10^(i/10)...] in satoshi
	var redrawStats=function() {	
		var start=false,end=false;														//initialise x start and end points
		var odds=1024;																	//initialize odds to 100%
		for (var i in oddsData) {														//go through each entry in odds data
			if ((i!=0) && (oddsData[i]>0) && (start===false)) start=Math.floor(i/10)*10;//find closest power of 10 to lowest non 0 value
			odds-=oddsData[i];															//keep track of number of wallet with higher values
			if (odds==0) {																//if we rean out of wallet
				end=i;																	//record position
				break;																	//and get out of loop
			}			
		}
		end=Math.ceil(i/10)*10;															//increase end point to next power of 10
		odds=1024-oddsData[0];															//calculate number of non 0 addresses
		var values=[];																	//initialize array for graph values
		var labels=[];																	//initialize array for graph labels 
		for (var i=start;i<=end;i++) {													//go through each odds value between start and end
			odds-=oddsData[i];															//keep track of current odds(y value)
			labels.push(i/10);															//keep track of current label(log of x value)
			values.push(((oddsData[i]==0)&&(i!=start))?null:odds/10.24);				//record odds only if real number.  leave null so graph can draw lines as it likes if no addresses there
		}
		new Chartist.Line(document.getElementById('oddsGraph'), {						//create chart
			series:	[values],															//provide y values
			labels:	labels																//provide x values 
		},{
			fullWidth: true,															//make graph full width
			axisX:	{																	//set x axis
				labelInterpolationFnc: function(value) {								//function to label x axis
					if (Math.floor(value)!=value) return;								//if not power of 10 don't label
					return Math.pow(10,value)/100000000 + " DGB";						//label how many DGB log value is equal to
				}
			},
			axisY: {																	//set y axis
				labelInterpolationFnc: function(value) {								//function to label y values
					return value + "%";													//add percent symbol to labels
				}
			},
			lineSmooth: Chartist.Interpolation.cardinal({								//tell chart to smoth arrays
				fillHoles: 	true,														//fill holes
				tension:	0.2															//set tension(not sure what value means found in example)
			}),
			showPoint:		false,														//don't show points
			height:			"80%"														//set height to 80% so room for header and close button
		});		
	}
	var updatePotSuccess=false;															//mark that we have not recieved pot yet
	var oddsLinkObjects=document.getElementsByClassName('oddsLink');					//make list of all objects with class oddsLink
	for (var i=0;i<oddsLinkObjects.length;i++) {										//go through each .oddsLink object
		oddsLinkObjects[i].addEventListener('click',function(){							//add click listener
			if (updatePotSuccess) {														//see if stats have been downloaded
				openWindow('graph');													//show graph 
				redrawStats();															//redraw graph
			} else {
				error('Odd of winning stats not yet loaded');							//show error message since we don't have stats yet
			}
		});
	}
	
	//check pot
	var updatePot=function() {
		xmr.getJSON("stats.json").then(function(data) {									//download stats
			if (data.pot==0) {															//if pot is 0 insight server has crashed
				error('Insight Server has Crashed.  Do not play while Pot shows 0.');	//show 0
			} else {
				updatePotSuccess=true;													//mark that we have received valid stats data
			}
			document.getElementById('pot').innerHTML=data.pot.toFixed(2)+ " DGB";		//show pot in top bar
			var odds=0;																	//initialize count
			for (var i in data.odds) if (i>0) odds+=data.odds[i];						//count how many addresses  have funds
			odds/=10.24;																//convert count to percentage
			document.getElementById('infoPot').innerHTML=data.pot.toFixed(2)+ " DGB";	//show pot in info bar
			document.getElementById('infoOdds').innerHTML=odds.toFixed(2)+ "%";			//show odds in info bar
			document.getElementById('infoBig').innerHTML=data.jackpot.value.toFixed(2)+ " DGB";//show jackpot in info bar
			oddsData=data.odds;															//save odds data
			redrawStats();																//redraw stats graph
		});
	};
	updatePot();																		//check pot imedietly
	setInterval(updatePot,300000);														//check pot and stats every 5 min
	
/*_____                        _                 _     _                   
 |  __ \                      | |       /\      | |   | |                  
 | |__) |_ _ _   _  ___  _   _| |_     /  \   __| | __| |_ __ ___  ___ ___ 
 |  ___/ _` | | | |/ _ \| | | | __|   / /\ \ / _` |/ _` | '__/ _ \/ __/ __|
 | |  | (_| | |_| | (_) | |_| | |_   / ____ \ (_| | (_| | | |  __/\__ \__ \
 |_|   \__,_|\__, |\___/ \__,_|\__| /_/    \_\__,_|\__,_|_|  \___||___/___/
              __/ |                                                        
             |___/ 
*/
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
	
	
/*_____  _              __          __   _ _      _   
 |  __ \| |             \ \        / /  | | |    | |  
 | |__) | | __ _ _   _   \ \  /\  / /_ _| | | ___| |_ 
 |  ___/| |/ _` | | | |   \ \/  \/ / _` | | |/ _ \ __|
 | |    | | (_| | |_| |    \  /\  / (_| | | |  __/ |_ 
 |_|    |_|\__,_|\__, |     \/  \/ \__,_|_|_|\___|\__|
                  __/ |                               
                 |___/ 
*/
	var fundP,fundA,
		brainString="",
		domQR=document.getElementById('fundAddress');
	for (var i=0;i<3;i++) {
		var part=bip39.english[Math.floor(Math.random()*2048)];							//pick a random word from list
		brainString+=part.charAt(0).toUpperCase()+part.slice(1);						//make first letter upper case and add to string
	}
	brainString+=Math.floor(Math.random()*999);											//add up to 3 random digits to initial brain string
	var domRecovery=document.getElementById('recovery');								//get recovery phrase input dom item
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
	var fundF=false;																	//set high speed fund checking to false
	var openFundWindow=function() {														//function to open fund window
		openWindow('buy');																//open fund window
		fundF=true;																		//set high speed fund checking to true
	};
	document.getElementById('addFunds').addEventListener('click',openFundWindow);		//add click listener to buy button
	var skipFundCount=0;																//count
	setInterval(function() {if ((fundF)||((!fundF)&&(++skipFundCount==30))) {
		skipFundCount=0;
		fundF=false;
		xmr.getJSON("balance.php?addr="+fundA).then(function(guesses) {	
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
	
/* _____                        _____  _             
  / ____|                      |  __ \| |            
 | |  __  __ _ _ __ ___   ___  | |__) | | __ _ _   _ 
 | | |_ |/ _` | '_ ` _ \ / _ \ |  ___/| |/ _` | | | |
 | |__| | (_| | | | | | |  __/ | |    | | (_| | |_| |
  \_____|\__,_|_| |_| |_|\___| |_|    |_|\__,_|\__, |
                                                __/ |
                                               |___/
*/
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
				skipFundCount=0;		//prevents balance check causing errors by checking near when game play has happened
				xmr.getJSON("dig.php?site="+SITE+"&pkey="+fundP+"&addr="+wallet+"&x="+e.offsetX+"&y="+e.offsetY).then(function(amount) {
					skipFundCount=0;	//prevents balance check causing errors by checking near when game play has happened
					if (amount>0) {
						//get balance
						win+=amount;
						document.getElementById('win').innerHTML=win.toFixed(8);
						document.getElementById('infoWin').innerHTML=win.toFixed(8);
						done=1;
					} else {
						done=-1;
					}
				},function(data) {
					//there was an error(probably conflict with other game click)
					document.getElementById('guess').innerHTML=(++guessLeft);			//on error guess is refunded so show we have one more
					clearInterval(timer);												//stop the animation
					document.body.removeChild(sCanvas);									//remove the sprite
					console.log('error:',data);
				});
			} else {
				openWindow('setWallet');
			}
		} else {
			openFundWindow();
		}
	},true);
	
	
	
/*_                     _    _____                      _      _       
 | |                   | |  / ____|                    | |    | |      
 | |     ___   __ _  __| | | |     ___  _ __ ___  _ __ | | ___| |_ ___ 
 | |    / _ \ / _` |/ _` | | |    / _ \| '_ ` _ \| '_ \| |/ _ \ __/ _ \
 | |___| (_) | (_| | (_| | | |___| (_) | | | | | | |_) | |  __/ ||  __/
 |______\___/ \__,_|\__,_|  \_____\___/|_| |_| |_| .__/|_|\___|\__\___|
                                                 | |                   
                                                 |_|
*/
	openFundWindow();																	//Open fund window
	
	
})();