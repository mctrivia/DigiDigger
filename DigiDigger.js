(function(undefined) {
	var bitcoin=window['bitcoinjs']['bitcoin'];											//load bitcoin library
	const SERVER='https://digger.digibyte.rocks/';										//api folder location
	const SPRITE_SIZE=32;																//size of sprite
	const SPRITE_HALF=SPRITE_SIZE/2;													//half the size of sprite
	const SPRITE_TIME=5000;																//minimum time sprite is shown
	const SPRITE_FINISH=55000;															//time win or lose shows
	
	//if you want to modify sprite use https://ezgif.com/image-to-datauri to convert to uri
	const IMG_SPRITE='data:image/png;base64,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';
	
	const BALANCE_CHECK_DELAY_FAST=30;	//seconds
	const BALANCE_CHECK_DELAY_SLOW=300;	//seconds
	
	const MAX_REQUESTS=4;																//max number of concurent requests to explorer server
	
	//private variables
	var _siteAddress='DMw9wz6KHsvbvXsmo1Q8BajWcohYwjqwoq';								//default site wallet can be changed with DigiDigger.setSiteAddress(address)
	var _userPrivate;
	var _userPayout;
	var _userAddress;
	var _guesses=0;
	
	//Handle requests
	xmr.setMax(MAX_REQUESTS);														//set max number of transactions at a time
	
	
	
/*____        _                      
 |  _ \      | |                     
 | |_) | __ _| | __ _ _ __   ___ ___ 
 |  _ < / _` | |/ _` | '_ \ / __/ _ \
 | |_) | (_| | | (_| | | | | (_|  __/
 |____/ \__,_|_|\__,_|_| |_|\___\___|
*/
	var _balanceChangeFuncs=[];
	var _recheckDelay=BALANCE_CHECK_DELAY_FAST;																//count
	var _recheckFast=true;
	var resetDelay=function() {
		_recheckDelay=_recheckFast?BALANCE_CHECK_DELAY_FAST:BALANCE_CHECK_DELAY_SLOW;
	}
	var balanceChanged=function() {
		for (var func of _balanceChangeFuncs) func(_guesses);
	}
	var checkBalance=function() {
		return new Promise(function(resolve, reject) {
			needPrivate();
			xmr.getJSON(SERVER+"balance.php?addr="+_userAddress).then(function(guesses) {	
				if (guesses!=_guesses) {
					_guesses=guesses;
					_recheckFast=false;
					balanceChanged();
				}
				resetDelay();
				_guesses=guesses;
				resolve(_guesses);
			});
		});
	}
	setInterval(function() {
		if (_userAddress==undefined) { resetDelay();									//if game wallet not created yet then don't try to check funding
		} else if (--_recheckDelay<=0) {
			checkBalance();
		}
	},1000);
	var bindBalanceChange=function(func) {
		_balanceChangeFuncs.push(func);
	}
	
/* ____      _     _     
  / __ \    | |   | |    
 | |  | | __| | __| |___ 
 | |  | |/ _` |/ _` / __|
 | |__| | (_| | (_| \__ \
  \____/ \__,_|\__,_|___/
*/
	var _oddsUpdateFuncs=[];
	var _oddsData={};																	//odds data is logarithmic scale.
	var drawChart=function(chartID) {	
		var chartData=_oddsData.odds;
		if (chartData.length==0) return false;
		var start=false,end=false;														//initialise x start and end points
		var odds=1024;																	//initialize odds to 100%
		for (var i in chartData) {														//go through each entry in odds data
			if ((i!=0) && (chartData[i]>0) && (start===false)) start=Math.floor(i/10)*10;//find closest power of 10 to lowest non 0 value
			odds-=chartData[i];															//keep track of number of wallet with higher values
			if (odds==0) {																//if we rean out of wallet
				end=i;																	//record position
				break;																	//and get out of loop
			}			
		}
		end=Math.ceil(i/10)*10;															//increase end point to next power of 10
		odds=1024-chartData[0];															//calculate number of non 0 addresses
		var values=[];																	//initialize array for graph values
		var labels=[];																	//initialize array for graph labels 
		for (var i=start;i<=end;i++) {													//go through each odds value between start and end
			odds-=chartData[i];															//keep track of current odds(y value)
			labels.push(i/10);															//keep track of current label(log of x value)
			values.push(((chartData[i]==0)&&(i!=start))?null:odds/10.24);				//record odds only if real number.  leave null so graph can draw lines as it likes if no addresses there
		}
		new Chartist.Line(document.getElementById(chartID), {							//create chart
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
		return true;
	}
	var getOdds=function() {
		if (_oddsData['pot']==undefined) return false;
		return (1024-_oddsData['odds'][0])/10.24;
	}
	var getPot=function() {
		if (_oddsData['pot']==undefined) return false;
		return _oddsData['pot'];
	}
	var getJackpot=function() {
		if (_oddsData['pot']==undefined) return false;
		return _oddsData['jackpot']['value'];
	}

	var updatePot=function() {
		xmr.getJSON(SERVER+"stats.json").then(function(data) {									//download stats
			_oddsData=data;																//save odds data
			for (var func of _oddsUpdateFuncs) func(getOdds(),getPot(),getJackpot());
		});
	};
	updatePot();																		//check pot imedietly
	setInterval(updatePot,300000);														//check pot and stats every 5 min
	var bindOddsUpdate=function(func) {
		_oddsUpdateFuncs.push(func);
	}
	
	
/*_          __   _ _      _       
 \ \        / /  | | |    | |      
  \ \  /\  / /_ _| | | ___| |_ ___ 
   \ \/  \/ / _` | | |/ _ \ __/ __|
    \  /\  / (_| | | |  __/ |_\__ \
     \/  \/ \__,_|_|_|\___|\__|___/
*/
	//DigiByte Validation Functions
	var isValidAddress=function(address) {
		try {
			if ((address[0]=='D')||(address[0]=='S')) {
				bitcoin['address']['fromBase58Check'](address);
				return true;
			}
		} catch(e) {
		}
		return false;
	}
	var isValidWIF=function(wif) {
		try {
			bitcoin['ECPair']['fromWIF'](wif);
			return true;
		} catch(e) {
			return false;
		}
	}
	
	//Check needed inputs
	var needPrivate=function() {
		if (_userPrivate==undefined) throw "Game wallet not created";
	}
	
	//Setter Functions	
	var setSiteAddress=function(address) {
		if (!isValidAddress(address)) throw "Invalid or unsuported address format";
		_siteAddress=address;
	}	
	var setUserPayout=function(address) {
		if (!isValidAddress(address)) throw "Invalid or unsuported address format";
		_userPayout=address;
	}	
	var setUserPrivate=function(wif) {
		if (!isValidWIF(wif)) throw "Invalid private key";
		_userPrivate=wif;
		_userAddress=bitcoin['ECPair']['fromWIF'](wif)['getAddress']("D");
	}
	var setUserPhrase=function(phrase) {
		//compute path
		var hash=bitcoin['crypto']['sha256'](phrase);									//hash recovery phrase
		var path="m/13'";																//start path
		for (var i=0;i<16;i+=4) path+="/"+((hash[i+3]&0x7f)<<24|hash[i+2]<<16|hash[i+1]<<8|hash[i])+"'";//add first 4x 32bit part to path
		
		//compute key pair
		var xprv='xprv9s21ZrQH143K31Jh4aY1efbnvR3nwBPmGesTahvKVdV5r7a4JDLQ5t31taNtq7sN94o6bCdzLYXhehMLjXE5rpmEqysMV8YWiJuNTLombsx';	//set a hd private key to use
																								//This is random key.  Even though the key is public  
																								//funds are safe because there are 2^124-1 possible wallet
																								//and under normal circumstances funds will only be in address
																								//for less then 1 minute.  Would take centuries to try all
																								//combinations.
		var keyPair=bip39['getHDKeyFromXPrv'](xprv,path)['keyPair'];
		_userPrivate=keyPair['toWIF']();												//calculate private key
		_userAddress=keyPair['getAddress']("D");										//calculate address
	}
	
	//Getter Functions
	var getUserAddress=function() {
		needPrivate();
		return _userAddress;
	}
	var getBalance=function() {
		needPrivate();
		return _guesses;
	}
	
/* _____                        _____  _             
  / ____|                      |  __ \| |            
 | |  __  __ _ _ __ ___   ___  | |__) | | __ _ _   _ 
 | | |_ |/ _` | '_ ` _ \ / _ \ |  ___/| |/ _` | | | |
 | |__| | (_| | | | | | |  __/ | |    | | (_| | |_| |
  \_____|\__,_|_| |_| |_|\___| |_|    |_|\__,_|\__, |
                                                __/ |
                                               |___/
*/
	//load need images
	var _sprite=document.createElement("IMG");
	_sprite.src=IMG_SPRITE;
	
	var _win=0;
	var _digStartFuncs=[];
	var _digEndFuncs=[];
	var _digErrorFuncs=[];
	var getWins=function() {
		return _win;
	}
	var bindDigStart=function(func) {
		_digStartFuncs.push(func);
	}
	var bindDigEnd=function(func) {
		_digEndFuncs.push(func);
	}
	var bindDigError=function(func) {
		_digErrorFuncs.push(func);
	}
	var digError=function(error) {
		for (var func of _digErrorFuncs) func(error);		
	}
	var startGame=function(id) {
		var domSearch=document.getElementById(id);
		domSearch.addEventListener('click',function(e) {
			if (_guesses>0) {
				if (_userPayout!=undefined) {
					var roundWinnings=0;
					document.getElementById('guess').innerHTML=--_guesses;
					balanceChanged();
					
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
						ctx.drawImage(_sprite,SPRITE_SIZE*i,0,SPRITE_SIZE,SPRITE_SIZE,0,0,SPRITE_SIZE,SPRITE_SIZE);
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
							drawFrame(5.5-done/2);														//show win or loss
							_win+=roundWinnings;														//update total
							for (var func of _digEndFuncs) func(e.offsetX,e.offsetY,roundWinnings);		//run bound functions
							clearInterval(timer);														//stop animation
							setTimeout(function() {document.body.removeChild(sCanvas);},SPRITE_FINISH);	//remove win/loss state after delay
						}
					},100);
					
					//execute start functions
					for (var func of _digStartFuncs) func(e.offsetX,e.offsetY);	

					//check if won
					_recheckDelay=BALANCE_CHECK_DELAY_SLOW;		//prevents balance check causing errors by checking near when game play has happened
					xmr.getJSON(SERVER+"dig.php?site="+_siteAddress+"&pkey="+_userPrivate+"&addr="+_userPayout+"&x="+e.offsetX+"&y="+e.offsetY).then(function(amount) {
						_recheckDelay=BALANCE_CHECK_DELAY_SLOW;	//prevents balance check causing errors by checking near when game play has happened
						if (amount>0) {
							//get balance
							roundWinnings+=amount;
							done=1;
						} else {
							done=-1;
						}
					},function(data) {
						//there was an error(probably conflict with other game click)
						++_guesses;															//on error guess is refunded so show we have one more
						balanceChanged()
						clearInterval(timer);												//stop the animation
						document.body.removeChild(sCanvas);									//remove the sprite
						digError(data);
					});
				} else {
					//no payout address set
					digError("No Payout Address");
				}
			} else {
				//user clicked and there wasn't any funds
				digError("No Funds")
			}
		},true);
	}
	
/*______                       _   
 |  ____|                     | |  
 | |__  __  ___ __   ___  _ __| |_ 
 |  __| \ \/ / '_ \ / _ \| '__| __|
 | |____ >  <| |_) | (_) | |  | |_ 
 |______/_/\_\ .__/ \___/|_|   \__|
             | |                   
             |_|
*/
	window['DigiDigger']={
		//Balance
		"checkBalance":		checkBalance,				//function().then(function(balance){})	asyncronous call gets update balance 
		"bindBalanceChange":bindBalanceChange,
		
		//Odds
		"drawChart":		drawChart,					//successBoolean=function(divIDtoDrawIn)
		"bindOddsUpdate":	bindOddsUpdate,				//function(function(odds,pot,jackpot){});
		"getOdds":			getOdds,					//float=function()
		"getJackpot":		getJackpot,					//float=function()
		"getPot":			getPot,						//float=function()
		
		//Wallets
		"isValidAddress":	isValidAddress,				//boolean=function(address)		check if address is valid for this app
		"setSiteAddress":	setSiteAddress,				//function(address)				set sites payout address if site wants a cut of profit
		
		"setUserPayout":	setUserPayout,				//function(address)				set address to pay winnings to
		
		"setUserPrivate":	setUserPrivate,				//function(wif)					set private key of game wallet
		"setUserPhrase":	setUserPhrase,				//function(phrase)				create game wallet based on phrase
		
		"getUserAddress":	getUserAddress,				//string=function()				gets the gamewallets addres
		
		//Game Play
		"startGame":		startGame,					//function(canvasID)
		"bindDigStart":		bindDigStart,				//function(function(x,y){})
		"bindDigEnd":		bindDigEnd,					//function(function(x,y,won){});
		"bindDigError":		bindDigError,				//function(function(errorString){})		executes when click but no funds
		"getWins":			getWins						//float=function()
		
	}
})();