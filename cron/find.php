<?php
define('SERVER','http://127.0.0.1:3001/api');

	ignore_user_abort(true);
	set_time_limit(0);

function getAddress($address) {
	do {
		$failed=false;
		try {
			$ch = curl_init();
			// set url
			curl_setopt($ch, CURLOPT_URL,SERVER.'/addr/'.$address);
			// return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// save output to string
			$output = curl_exec($ch);
			// close curl resource to free up system resources
			curl_close($ch);
			$balance=json_decode($output,true)["balance"];
		} catch (Exception $e) {
			$failed=true;
			sleep(30);
		}
	} while ($failed);
	return $balance;
}

$filled=0;
$balance=0;
$max=0;
$maxAddress='';
$values=array();
for ($i=0;$i<10*18;$i++) {
	$values[]=0;
}

$possible=array("D5BXM8Kz2xs9w3HqmmoAQRABdyuwibqxYp","D5KDEL24HcZjJkmQzUZCmqetoLhPs33jkN","D5LUbfgkr24vuFHgr95naFu6JVQdQAXBta","D5MBLEYqwboE4jtPaR9a2aL46hMthcCkBj","D5NjC6mC4Ugebeyq15wVv4r76ZvzZdSNER","D5PQNz4Q59V8hMjGLtiiwQRL6GrbWz4hCZ","D5Pip4V9VxDG4zMgYZKFKk8p2optkDaqkv","D5U9jcsC3nzrTuGWGcLJzPvEhe4dTpWySH","D5V8VtXUMZV48Lt1nVtrCNHV3RhNGYweFF","D5V9LPWdJeW5wmo8zZrL3rruBgwWoGHtTg","D5VxP4a4QkY6f9DNS2oLwubUwhscuek5iJ","D5WjFTBof1oskrH67a4mqfwQaqvmT7yNgf","D5YUFpAgoHzPA2gU9o3UF8qiSubboC3u3j","D5cr2o53NUDzQk7ShP1SbpS6J8hyKpf5Az","D5dDtpk8qsPUA5FxUTGSRuBxAffJin8quC","D5dXPFpbjes4XdaYhfgoypFhNewTmjsPi2","D5fbu1FybLUCXNrfzuQVB2F5RmaBUtcm5W","D5h5nLPTxPBRm8aWqfAsPLRGsmKZ8NPzYN","D5haHzrNUcrApaY7ogWcDqYwTMiDRWz2SE","D5koa56Sz8oQ8s1AFMmvN9NCGcgM4vePmb","D5mzrPMEakYzPvfwAVS3NrkDiVJvRv7f4D","D5nYL93bF9g4PhcAhHNueSpcqwadt5rvLQ","D5oVzkmHu5tYkjeXiPYRWxXzLtUnnxJoLb","D5pEcjUfSrRchyxPsdQVKW6H38YabrxURq","D5qZ5D3yq4AHF65DvGAFcPXfB48wGh4gW4","D5r3pWpAKcyj3ku3U7oGkWPhax9DCiM733","D5rn1XJHA1dv3NrXMSAyMFRg7mNcBkn2ZU","D5sSA2JXmiP1ajjg8y17iv8W9GsN1SyRQJ","D5xLaxmPvya61FzQCWeFeyyA42sCD5KGNb","D5yfrSKw6nijVLJfdytjkCDNSw7P7rx8Yk","D5yt8yV9C8SDGQEJyH4x2kq9VBmNuBmffj","D61qkqScHF7o6TPMBNhu88x5CLxza3mPTU","D62Ua6EVt4wPJFky89oSAiq6A1BrSSwcTK","D62sCWqFRbqs5QyCbpuJkDECsQqBQ6NQj8","D63SARAq755YzysSMU6fYz9XcgMNhkxgtQ","D63uzpQhw29jG3Bvu2erwWLVadx5SzEQEr","D64YdmnNQj9c2JZScJEj6mPUFEEnjjY4yW","D65EWC46A9Lup3ZzPw7ZtNNc21qLhfRWWu","D65G58hR3jKT54RNTsL4H8rkcseaAXZT6J","D66GjX4u3yLFAZwy56UcsTxkqFBCjTr5E3","D6BjjqhbZmyc2xG1KEHQS12yF6NbcjPjWS","D6BsfJS6Nm2AHyauUAontipHioxJtCSLxt","D6EAdUmH5J2SAb1snh2Qd2aze6WZvwp7i7","D6Gk8WREXnjEvUnUHgLq2F2sCPsMnZ5sQS","D6LrBNqbBcPNdgjve8ccBmVz73t36Eet4j","D6P9Bw5Ea7tAHimm4FdivKmWwTrPwKVfxo","D6T55kPcZdqKCCFH7xpDH6QgUUTQrBNGfW","D6U3XkKRwiXD7nedsbgMm1iobeJAKY1hcN","D6V6Gu1soVx6Ngr9NAyDu4Qommw3428Znu","D6ZCwfAHDwZJ2TQoRc7waQHUeMpVSeTHiT","D6cE8RK28dGP5UqTZQCVwo8e2PHdTPEvGm","D6dHYi6YwqLuSUk5q36NwdKt3GujzLxkeU","D6gLW9T5SZe7916ZLwsk2SFKwk9UKkhFS1","D6mtyxCXGMN26FkYMjQtnDX9kUBcBJY3nQ","D6ndhihgCyaF6j99wMhEw5Nj21Jr5YK271","D6prVLDvWm14Sx6FTAw1JNYFb26pyEkW4p","D6q6jCH7kCtC9fieg3eoAADYgE3Nekd5t8","D6sGV1knniicU8tZfLKAH8sDre4ArCRFPN","D6vGqeNVAWEJ5vKgMjvnwMpKpfMzMYsUyx","D6zyVKHDu9T4B9R5Uy5CGF79mMBpqFUZ6y","D73Akx76dd6eUENpXCQAiPYT4rKZnMnrRL","D747rtYEdVranuLMy8r2mk7UTThPhZg8JF","D74nX1dZQ4auWdqEncPV3eD64i7tyZ9wCT","D75X8jrGy6RTYxjBU7UvALEgzPjhXhdos3","D77YjsAhoTsha6u2vw4Q2vf6sWwSi5SKdy","D7AYqzwMRMwShi9mqnMRbePp7ivJUXMDMJ","D7Bbj78VrQDKYDK687zav7DWzKZbN1KnW2","D7Beeo4q3avkzu3qrPz4dXTKRLEskfwrSu","D7BoNk1WuA9gQrmbftg6JsqypntAB7vVQR","D7EHbTCqiZKGx7N2qqAtFNrwYqYAPybSpv","D7Ez6CYKA4Pc3PNZciuoNwAAsct6duP6tk","D7GesUCbrVLS496RJuXySfdCY7tRqBgYxz","D7HML3dMjkJJEXudoVX7bs9dbjKZcwdPCn","D7JwmGpu14xV2rEJfu9unu9WmVVwzdsVtd","D7KRq4FiTRUrCFq9NEEA6zQFNan2u5cJb3","D7LFGToabwUFmQNmtLtqtDhvxQ87q6t7WZ","D7LfT3qaEQyHWYUvVNYS1MDt7g6rijGvJk","D7MdquBpLGVPoUNXkUAHLL1iUZ9XruXQQ3","D7MqvezCoaJMNNjNApZ6M4C6HBqLWozzU4","D7NYN3fY9wGycFuXctfZ4CEzDa9JChbv6U","D7SLGp2TqUeXnj1wMHkrrXdVFjeHKsEsam","D7X5zqy48Dhei6Wx4W8tXyzQdVMtWNN5tQ","D7ZpFn1XjPbBDPBTN8x5wAGLSjkfHnmxMm","D7bpoF2CzB4A8NfdfhScMnc1yvo8RwYqPq","D7f181ut3AecKAzBjS2uD9hkKu5ouRqvKk","D7gGzbkQZ3NYLCfsXaELyS6jACuDMwZ76D","D7gUveR9mfCVEWmx6XrbMGgP44Sd9FJZcF","D7oNKBW67qKQE8JNc5ZEq3Qazr8sKNAnZT","D7oeDmz2VLxRob6wvGKnns35dN25ZXYzjT","D7p72VRmQCJs33SM7i7xuKbkf7cJQ3vrVN","D7pqwjh4Luo3dwUep737ZjkyVadTd6Ns4n","D7r28kcQLM9h9TzxxEoNnLzjEqUMZvce5s","D7tthrLBChAKrcgzHnWArEim4DaSmgfBWs","D7wBtNVW1kPhGCJSco1AUeqgAJ1WC53ENr","D7wMTzeNEm57AsL6oaeBg62upfHAovpFVy","D7ydUPYamEry58TswgjTUzU4Ae6uJNmiP2","D7ypjWMk31pD3zyanNpvdy4WcwMgNQsiMW","D7yqFkWgKEGJomNagiRbT9hm2nMqFco4Kp","D7zPk2HbeL6pkCXXhg51fEQKa8zD9TaUrk","D7zqRQziMjCP3JXmCJgrH1ro8brhFTAidH","D81CL3MnGE18WpNaxyzKz7dAmvBCrcSDM3","D82uGTtRC5ZzgczPAL1Cp7fy52H8HamwDh","D86aSqpnJDu4qAqmq9s7RVadUCoDrxbYac","D86iApgjNf9tDXNtGu54iAgaZqguY5sohh","D87NDkvBWSyoEtBuTfPygjuYXtAXC6Fzse","D88UYrQ6xg1HpEKrSc5BycHrqG8ortpGdW","D892r3JxdzQbo6wNMwcZwehYvNyDL6ComH","D8CD5epsXAjUjkG9RER9w7igaMBQaMnp39","D8EJRVB4RNgQdD3iLWgPTeiW8niz1bgxNg","D8FNARCxjjSxwhSoQnykS1sHX3uZ35juBD","D8GNfymfCvM9JUziaxk7mUTWbb4v4TH4VD","D8GzL9asZWYR9LVWBGm8zGRjMUsRcWqiXM","D8H5pKW9PtP7VyU541w433tq6AZCbiqNX2","D8Nt8Br4AgQdDGD7B7F7tcCVy8pVmwEgA8","D8Q9gwh9YyMgHuk1nMX1kaQRwpCk9JZqNt","D8R5j7rLbcBubxLNSqT6w69VfJt4sXHSia","D8SCEa6YegPd3Xe5bmvLNyGjdKCnazgq2q","D8SH1FcjnaxE5AC3ahG1fRutmu7Ja8gtLX","D8T8RCpLKp4XufeDyVk2weYhR6brD5VLmw","D8VMHjqhpryPStM1CingJbWmrhRf3rDLRT","D8Wr7YQ2WBtuwyT5hrMWjKahtJCqYLnVeM","D8Xa6XsqfvPwVgMRDMvkPEMgfxLqLghJfi","D8YbmuUUmgKK5uXUiqWAWYYZBxpiNNgLwh","D8aFrkwLGFXmWyt1GPfSsKPBJ1FCR5jQUa","D8akHcPXF2m8WVdh9Vev8m8eKUrkjx2GiM","D8bcygyrJNM1abVFxUXwT1YSJhfjKAe1B6","D8cBDxffb1hs6JRhdbm7txzMUXNskf8inz","D8cfwRVwUyjhtThS21Pp9xiXeaejy71CXU","D8dk3K4bxpi2ZhhM36wrxC4nusyw8sJbVu","D8dx6j5CmLSexnGszXk9ksPms2UEWgv5GU","D8f4mciofrncKY2L3TMrtxWQPzY1DWw1vT","D8gEWRHfqu8b6zBn4cQj1wkFbEwCum7QJL","D8j28sJUTuVvMDDCiQajMB5BeEiEqB8xiW","D8jVXiZYrXaEFg6Y31Zd7ofXrJPXFyuwpP","D8mA8BfvqPeHNgir7jK5Xq6Npw55gMGNrv","D8nMR63V34WwJG8oNvLMwYRJg3ehmmfLc4","D8ot82xr2hMZE8QjjQdbcBKnwDoeFatztk","D8ow8LJRjujSJXLFRHqAVRJdLn91zoqaLb","D8sz8xDyqiPv8yXjxygPSakDMn7TRuEy7Q","D8vuMyspmrdKePJBc5TBJ9bH7TkGGDq6bg","D8w14jHqpi2ngB8Mx2dvAX879C6jHnnpS1","D8wDcfa1UvBPSnyHZdQnLNzf29hgWpP7Sj","D8wHvmEe4oaqsL1W7cTetYDf635crSBFyM","D8wYH2sLqpooK7nbhGo4EvKSqQa21WQjZQ","D93SQ1VMzZKEMEBdpPs1YroeSuktxptrvF","D94gTcPCL1CARduhnrhrZG3U61XdDdKbAs","D97jKc4MmvSc6J39bdxMrv12gMraV27xLd","D98NgqReymt8tUTrRgcsahFKZpDs6AcyUh","D98TtCo16rT3axjc3RZtUmuEJ3zn9f68mx","D9AE8E3ShiYHwQF7C87jrqPzckFU9UxjZB","D9BqjqaeD6qk5eqZLXYxABNzjbYnUjrNRt","D9CzDnb4FDP7uNuF1ryB92kCymVqkSB5UJ","D9Db5n8pA5ZGv9uwxRsF5HnHeNtwRCupeA","D9EuRtYohvsSBFU2wMuy7rdCf8HSLW1aK8","D9KvipRZYLniRNAYsvNLDUEyH8q6NQKBNW","D9L72z9KXVLbNyp5RPcYirVPcoYiX7Jczc","D9LKUzmcExRz5AL16UHTucYPLmF3HpKJg7","D9LcsNPEKS5s5AEM1zTsCmbvYABoKK8D1n","D9NMQkbzg6LkXnTffqYTR7mLhNmg3vECao","D9NS5c5G1F8X6dkNDLVevcqH2NWkqUvHPo","D9RoxvRPn79K7HiMekztWHCWv498pT1MVD","D9S31fWaQggDs9dQqGQWXveVBkw1xWdw93","D9S91dRe1yQJR9dmdgEYV5NeNzVTGs3WVN","D9WQzcFVwj3Mb6yG79gsonCgtzmwmZJLhJ","D9XKPM6quL7mX3WNaMmmPPySgRo8mLZ1Ee","D9XkSbSTMGqXJv3q3tnJUc57iCEyNm3ds4","D9Y7XxE5nQNPpjUV8bjyULMqExrCd4cQGM","D9YErPrUKeZGwbs9k1oNBEPtQX7A12fzPB","D9ZEumJnJDFC3y6UHxFq5UDSURTg8u8d9E","D9ZUuGV8ac8NJQ2XVWidAmv3rPA6ai6bf6","D9aPHvRc2QDSeoVWcpLQKfx5hLbKiTZ3cQ","D9bQx9aR5tvZGUNVr1z4kSmvLJnMSgzm4j","D9btkyD8tPcf9SMLaueGNru4TdBzdzBBuj","D9cq1eentS39BCbkD2GwUSXwVAG9F77V19","D9ePe63SogBRzFWm4gyW5q62L2541gk1CS","D9epHe1RWndnoNorjF26aXPeif84YDgt7o","D9f7D2MNMGwJnNH1iBcDFaRxnS5wmpbcLs","D9fqR48NEiHuQ5EewtviJM1825rkQjMPUn","D9jLDyAGxuD4GgPaaTvsLSkYDp1Udo6pRi","D9kS1ndFqKUSBc5RLYSxtxyAs37Nfy9PYP","D9nj46wthYbHg2Le1KUXhDXikef2xkznat","D9oBKHxXnibuSxBUPSViZ3tQz5AinBxgWa","D9ps4oeijxf6J4SCads9UT8jbQsGuLhTaP","D9qiArFLFAPwSwKQ99StcpioF15DbQNdx1","D9qkLmnRw7Q4vqtxDxbVmoqjtwqGeY5NS3","D9sPeieASGDmyfsv4FcUvrzQZe9iruEqhz","D9ujCuhYUwHEZQMg6KJrvvu12JpE8DZ46n","D9xJJXcMuBHpBPYVe6aB8zUcsZwAZRapUN","D9xY6yPM2cEQBMGqTJtkKFUj4KQbZwZP2P","D9xrf1eXXKxkDntuEa7QHzbZa2hnor3DLt","D9zKkomuM6mdGCfEDkzmMEbe1hyZoJGCqp","DA1V7vX28HiSn7aTJFpC6W2LfBiZxvnmkw","DA3NaTVr5uNBCG2kjtiqRWG5WnFbLCeJYa","DA4yKBxKCdxSwVW4Jg2jPraqYHJxLBTz3y","DA59wY7ajeuekkYmsNRc6A6XT1qNHEMMn1","DA5jVKEqU4MfFmdAFSyfgWixbSfiwPgENC","DA6TTiBrZ9364175rGTGypwYA1wpkJfJVj","DA7ZqrrNuYP3iRW5juP7oz3z3rFJzLM4MW","DA812FraZKLmkyWiAQtYfu1eVHFum6QPaY","DA8dh3BDuLChyZxvAhwDcxz8yasJyHcup7","DA9wt5Gncx7bKPTxj575FrV9NgtoFp54Cr","DAChHgoiJws7R8ARM5GYFwJ9S1juEPb5Z3","DADHskakFGjKSj7iFJhRRh7CEja1xsTsC4","DADQgABNKBNwUzENyE8cbf2q1Ck6HxeoUB","DADR5WdXY3sehWKqQkwbhufPbkQfFsXh7b","DAJJNKMGiNnTXp5ie2mu1MxprkkGG8DxpT","DAJsiXoiBVpTLgq1oTRdvrWhyqvoNAWAGo","DAK1DzyfxC7bGH46scibs5g59TtfuNKHfU","DAKnNyMWKb58JuH2sze3xANMowVwoWewNh","DALWtK12aeVPT92j15CGRipAuFBVE5EKFb","DAM3dx5dqkvm7LgW4mZWz272jD1mKgJeuk","DAME5ReECocPNzNqHk5QYGdkoGcaPetkwq","DAMibUuWhajKM98Rz4XjJYXygH8AmRP2SW","DAMmJmVwcqxyFHs1G1hoVPNyH2iTL1GRwZ","DAMw98iNxv4Hrn477hqCvoN5xz7ZNfKPSc","DARXeV1nM8QHqDfBYffhGsr2DypfLisrJQ","DARtdzvetZyYQgTJLuNKponQbSG7p6qgE4","DASMDmxQjFBdAkUk1YkBQzCC9WpzuMccQy","DASaYP34bJZawTfxoMmsN7SqgtT7YWcS44","DATFgEGnADHsiZbKgXZDVgDh2dTKRYpLPP","DAUCeaibQJr5QsJHkwk1sr3vtT2V9jz1LJ","DAUmachCGWMeQoR8sn25UgCrvm5o2s33jt","DAVjSDFFbBUp2EqAh8xjVGjQHuxeWL3Bd4","DAWJBvk9a9v3Ma1xxcoRNda4svumD2oQwE","DAWxHHUjzfa8wTVna8anHwTGfwGePBQTm7","DAZtKVgMKE8t4vhH3Fobs4tvQDATijuUte","DAa7reh6ydZepiHJw3qVgmBdvNGmoKfBEG","DAaCXKW3yogzTWpjsWhb6XMTeR3aQ5Vr7t","DAb4S1L9cj3Ztp8eAkhxKxs18p8W5qXDYa","DAd6ZPBTL32NJpk4zB7Q4fjVij68yK5MqG","DAdCH9cwtg7bPFH3n5VB5ztpeYdpoPwMtS","DAdD2Kx722DCKCVhZicaoJyegCkRAhdUBr","DAeMbHR1NXayZDccCqkC4A6T4hgi4LHT2D","DAefobZ7MG2KGCitFC7jDgp6ZvN3NmsYrF","DAfdSpo2ewcrHUKDevk86aWHbtCgbdsJDb","DAg78GEEourHRD6arEHhQa5knuVSETYfoi","DAgGoXhBCXWhEqtnBXHzxEe6ZfoFo6av3e","DAghthQPj1jfyxg8PJsVSQMxSGpFQBPsY8","DAgy5JBszbiinJeWJAaaj5prEwR9f3Dv5Z","DAjW8iArajzu56gZd97KiLM7c1m34Azxit","DAkkeb5zLMaaQa3nAU36zd1dnWjz9yi3ER","DAmZfqgtBQAYGYAcJVcts1PPahT4Nyhurm","DAo3n4sqvyjXz6BWCggzrcF4Wg7QccZASe","DApVfQrtV7grN8q4prJRknpLKgboyw4P4i","DAqJFp6XxD6WofMDjnQPUFx5qRWFx22bhS","DAtPSJZfbjqmpyvxYBXhEKFWgWekpRhHwa","DAwVAaopatba1P9S8Q3J651CyrAGnJc4CE","DAzni8AEKgCn1P469HCL4KwkeHstiY66sp","DB1KYcMEUkaXwmbFNtK9Qds1ik7wpfTMcf","DB4PHwGcZpgxXWmG8VZtKRwpZAHHHMUCpt","DB6rpsrG9FrREZvSqvb34muLmHftqvtHXj","DB8MkN7wc6mXS2nXf54QHttb97UtSPq9dH","DB9fd6d5tA2VxmKkqKK36UgaSdgkMEzM44","DB9khjNoP6n9X2uFfhdYejBGVWVjM6FVqP","DBC1rYWnc9HYgTd8PHyan8Tx3s4RpZXQva","DBC6aJxZGGZopMTywMCVcMHeEiJgrLcQ1y","DBF4XoKTXNmdpy71KTqmXEKBD6pcmWnUDN","DBF5FuCX4ZopAZ2qEdv6iVtEnwd8tAgHzP","DBGm3fUSyk6t2RTsbdpxS2oRvKivAdjFut","DBHFFiWKy6tjxKMACWmyiAae87bgfVcjB2","DBJJ7pmgQCsa73DFFAuPdbXKaaMFG3yTAU","DBKURTTpjvDFWEwKVAZgZiQSGQT3PHmVww","DBP6QiFP9ojNwWNGQefV8aARNoHJNbuM4m","DBPbR1xV7AEEhX3TNZv26haoCYUnuiz3Vw","DBRDuBezqNWnQXXC1BNtj8BPxvSPpgvz6Z","DBT5mWnNbdtgKuKB55UCBDZZUz2KZg77CB","DBTY8vpLhxhrd3FBVPsyNSXibWHHrV3Gy8","DBUpht4j5gkoTNqWki2r1AwgMPJxWeUxiM","DBVBuYWdB7LY1U2Dg45Ag8ucuK6aS25hpQ","DBWeJJWitqFDEdgjEkjR6iLQMXjoaQBNnN","DBWfeX9fKSQFhTmaq9ow6cCy48HPJgaQTG","DBZSv6wkkE9HgWEBY2DntiN9a6HeCjwsAt","DBZcmiVqigAkZbvjXa4jfFHkX5Dz7dPux1","DBaSshAxaDMQx7k5ewA31gaMFSdyUkF7xy","DBaywaRrdCRmpnxpffwhYvh8aPBnh3u398","DBgeHAVzeH913RLv4KSeWPYr1tzDtEDuyf","DBiJx6N6MTZeW2bukTSRXcNdrZvnUtxTkM","DBibe29QhYSnNoC5dwPdPDcrNhS5rbuGCh","DBjxqrBCVWBJVHp9sUof97hgMx6i25xYTd","DBmui8ysrcvojdzTmXPFisVLzRFAxozFE6","DBn55vzAsiPTGDz4wq94gjL8VrUJDbY5F5","DBpsJ9DzDHTAYXbDKFVUoFBZYCU7PcyqoF","DBqMPr5Q5gTGtETdWrxXvBquH6xAkWcpA8","DBs7WZDhBShGwc996gHy3WCFefNxL1FeSV","DBtdepnsXEbsg9CgANf33AWMKaNqFT7HXV","DBwPhJFjjkzy6Gz5FrQQeMsfU7LipuavkM","DBxCTC4sRwoq195P92ZArK4Fwcz8rReRhb","DByH6Y8PCoxND9G1a6iEo4atmdZ4fZwFY7","DBygGcJT1BARXxPqbyHDkbxza8MvFwz9xT","DC11jjKa1ohJMqC9vjpVMQXu8GwgbFWDjP","DC11mEaDAbf9ZKeFFSNEP5w5ZQuyHHRafV","DC6AWm4HW7owFmQY5eSnVyxvRt6na4vNrZ","DC97Ky8QVi3wJ5avhCQNfDtgjrbuN536D2","DC9tHLHoe9Z5uTEnGkQiQkDC6KDumLobsD","DCAu1AieWAysEpdbHW6wMWrL7Wo67rE64K","DCBuL2j3iG55fZ4WL9eATkhskzYdCEse5U","DCCEEfZKV9ZNZpCjFhQj1kTdWuufupNFKi","DCChRaLuBvBvj1Xk2cTbicxWNQz9sL7oEQ","DCDeskP3rZmXoSVx9aEhL6osDCxjtki6kB","DCGfyps32umVySxkiJEUnD9DPdUCZAiE7J","DCJBoEtWWHF21si5JmNwnzezMSmj77KYGG","DCLtVGgYsMtt9iTMnCB5Cwav5gnKM7bib6","DCNZeWPf1KTeC1hPoVKXGk42Vo7F6bNE6Y","DCPLeGTzuKrwFiybViCP9gJ6n1jyCNtyNh","DCR9StfgDbwAjsaWQP2wx4r1qbmSPiDvTU","DCSSpRmFcvFRLLjmU8NgoCXWFqqTDqCW7c","DCVj1RajLFYU8ReNoeTNecZJfYYy6VpgA1","DCXr4oZ5qdkYxAQX2LZL6U4SmaftgqDZzS","DCYHH5ApeYEdYNcXyNyssrGMrBVHQ6EScV","DCYN6ervjAhiFwziwxirwFf3MWvFubpqqL","DCa4rrfUjuGc4fzxyJDDmsj6CWFUA2ohzv","DCkAJZv8VjMoCbiyHwDwp9DyqwDypQqdZC","DCkRNbrLUqRBb9W4XmwBEMUVyVzezrKWh6","DCoTdUyeYTHU4P4dDnwhMcDaBTPD6zU6Lt","DCqaKt3Az8DNvPQeV67C6A7WkqbxhAuw48","DCr1QbA7CwH8gVfQxCLtrU5rtQ9615opQe","DCsVNocfcH8pnA1VzUsgQUpkkRxL9CSpbJ","DCuooth89NTJRXgDpiRazaAH7QQinYBxB8","DCvtu1Xme1WZuuwuKbPxrx1kguHUbrRoKz","DCyeEXT5DsKbHgye2bnJUL4jGijsHQnab5","DCzMMZe4mRjNJubdT1nn45ky7fg4tpryYT","DCzTn4riYuTcuWDkMYUoETGfx4YUe1se17","DD18gJFZPaU188r4rFuktMhofNZvW9xb21","DD4AgpWay38nBGanQT9hkcugAcj8DbRZtj","DD5DMDPVCwztqzjiz7fNeX6WjSehxtzHyk","DD5HUrnfGFLtd5Dk5s6hsojhzpnqLWg14x","DD5eMiJujvxjXXrSxtjuWxWTrUpXjFN76Z","DD5gwbZ8J1SU4BPFXwTeTJBCNwN56j8RHJ","DD6ksr29h3D3MkEAofvqqkzpGu9RD7zd7Q","DD7NxCMKmWbnzmMHs9QeUxudAAKaSTDn5p","DD7iDj3VUjtT7zBn7TShQH5rJhdCPnRUCP","DD8Q6Sp9smqcHfj2LCWtBVdi9XU3BGUWc8","DD927ua3Cd2citutU5qaTktFcEEm1iGkPy","DD9TY5xY9T62gNraegxJbP9mQKpvg1y9EY","DDAKHsDrVJWphWhZF8QNFgA7yHy56j4XBD","DDAX1HacGgSZP9Sx3pvaTRzTk9akb7GS6h","DDAYbfJKtNMc7nMMRUshMfDgsj9fJDQ7Ex","DDCEwXEnCm1atwqYeGwbWyV8qvWbw89rzp","DDDbZxM26BeeE3VxKUtB3G48X1ooxmReYJ","DDEu2mNrup8KDkFDt1jnBjCrVbPdrWnK5z","DDGJSw2tvmJNdT8WzjbUoz57n6EMBLwNHf","DDHeA3HGUTVvzSZiDNbG1e5mhBhsaNZM3H","DDHg5APSMfG5zouBMNs53NmraPhWhqcf5P","DDJaKJDRWiwKUetsrsTBnNKoHAQwzT3DS5","DDKPDiByhUgPS4vjEeNHKj9hhA1GGMJwfh","DDKYj8oDFMAinj5cnKHyFzW9YQ6s2yzaCM","DDMvuzRA2Bi9bFem26PtsvLkk7j1ZJMJsQ","DDN547DdS2qQeU7auGg598WC7rk88fzKXC","DDNFWuz25Us4CVv6NcmuKk6QEzWnRYPwaX","DDNkXssGhrbQzXcrFx2dXx7iTPdaUsAKYZ","DDPx68WUfJk4ffz7S2BBFczQNHp4aj398T","DDRwwfbftCQGtusGzW9UA9AQhJagvn7bXV","DDShcWNLyxBZ4c1KpwFioADvXyCSfvo7Et","DDSy2SwL3vDRMpKx9k8dgFRrw4mtwz7qoJ","DDTBH3STp7wj85gtSWriPpkRTaDebd2vgH","DDTq4JNrbEf9PRuuAFmdY4s8AdnCmRARWB","DDVAfnUoQSoQ9mXuoTLAXP44z1GXCgzbGP","DDWZDoKQjLtfzhidkQ7LnCHtujtgQfs94p","DDXLyK3iF2yz64TSgbVkmJqBY5sFvu5c8d","DDXUKpLFnpiN6FLY59vcVgu32nZRvaZWco","DDXXYLEGi8nT4wP832yjGdb7waK1bsLamT","DDXwzVUHWh4Q8rmpVZmbuyv6mKaaxs75ya","DDaqa1UgK567Dj2KtYEEGeZYDXjw9hBwPh","DDbgdS9rMnv9hqxFWyQCBbVGN6YH1LvRUV","DDbo8c5P9KgEuy8Uct2Zf8LJDa984nwZTE","DDbrc53XgyJ2mspozB44rtNGcLF3pbguNg","DDdoZ7jg81oyuAyiyxcb1ikedqWN8jaqbF","DDehaweMMKDAWUcF3Heiojvzdf54UJg2x3","DDf3YSdqrE4hT4EPuzTvaBE4AaakF2FtSE","DDfAt6mYFXeKW2DVjtyAyv82kCDwTYhmcX","DDfMDiqA3Er4nK2EPFUupxT7KDE5HZCfQA","DDgudvaXdsoY6dj1rz7pRFa53HiN8wkub1","DDi6TAjcd739Zk3LsJQVBkkToUzpsBmzJT","DDjneQk7m2Cp6V46KRZeCzrD5KwdPenUcu","DDmNS1GAtsRZsW2qjRxbf2PyHT76ZzYFFU","DDntjQ3vjtWcDoa8JTBrVbYs9i6H9bmSNj","DDqikDtoxV9fJwmRskzYKUhinEQbRG8fvy","DDrdKxyXxyic3U8xq1w4BRCycgC5aVA6Db","DDvhShnGf2pW5aETwZPmvwEukEKc1wQgMD","DDwWmBHSwrdgr9wbmex1eKK9UydsyHZqFk","DDxE5g2E4mrh6cjoJyaJ4LL3v1Saj8ThRp","DDxqJ9ASo7JiAP8SLSTMLJtaV7P6jRjEp5","DE54XJTRog1MkgvX3GB56ounrTWA7zoZYC","DE8YxeXUpiFhdioh36NC3Jbn4RB1t52js8","DE8tFAGwHPAc1Q7yScpjQfU6TauiB8oHwv","DE9rVDSrkv5fDp2xrUiLtc12sz9UViY1XU","DEBepro6vg2rj1dKySuJpnabDHd18cqeWV","DEDadxaHtZjDa3gjQwWi3eqbBCVCTGEUSX","DEE7rU8MRDdDQCUfDzNzxnMGw9JoKpVWa2","DEGNsiSWVZ5DezEjCktQymGUevpz8XvtwH","DEJKwtWwFyHM4jkcZZQbHfw5MYMJmztJjz","DEKrnVK6PjKVE2FawXgHwaKMoWu5gSTHs6","DEKtAuXoAVUJ7oKz75QEdviygYUBSaqU6T","DEN7R1KmkNLJ6a6VrqGMKi5pVnhVrCZoyG","DEPAgQXWyQNzqR5MCHo51YAEcf7BdiQwjx","DEQiRpVrZk6NURBDALmsPm286XcBj5gr7j","DERSXPyEfbofDbTarb9ZVbYLTDRrr9Z2TQ","DERa7v39hLsdSxhMJW3TamLEFDGrp29SGN","DESQWT3n5shKr5zc25nJ9pdnHorq9MSmck","DESwiD6wrg2QHueRgUYpeRhd3y1E7Lgaz7","DET1g2GJ1oHFAJSAYXDjCxQKN5Lvad9LTP","DEXaMEEsksk2sNXiD6AbHZHj4rHFVtwRje","DEY4B7ws3hB9NLAurjJq3caX3PCwbCsnWT","DEZxAenVZHYaLqGuRC3qDVpncbfh1axqcg","DEdNA3DTQ9py6uopkd8Q8ECt9vHUQTdk6s","DEf9yeHtdzi7h6i6AwXjpkvHA7zmvngNRs","DEfGAKcz8qcFZdBsfsyq3abJ5FAdeDyGd2","DEfgoFijygkjLKMr9vGkHxUV7UtZYVjayA","DEgALqCSeeeaDYaG8j8gv2S1E89r6Gf7kX","DEgvxSoozxuw8yw9pQsEBDeDb6Sq4mEBE7","DEi9iYFibQCH8PW2fzGp24A1oqYhfm6tGb","DEjZoEnWjmZP96bnJ2QacKS7inHfGwgSvD","DEjb5MoLiNjRYHKbGU4bRKauH6A3ZwBrJU","DEjeCBH9ccevhT77YtLdUHxn18msaE3nn1","DEkD1umiNqnBPnuF7kAaENVDqkK7Xmx43d","DEmCqYKrBy4kJa7j2AHTXPWMw1hkifC8as","DEpLwhubeuXhDzz8jSx2ZzvPLAVi4LUfQD","DEputdEcbw2vtAm9jZ57hchrFHfc9EAYet","DEsMvzhhnRiCpfTVYfCAbUUSE6LC9H1ZL6","DEtDbc3Ro6mjs1HKzjW9Vfx8gXoaEFzzc8","DEwUfThghX9DUDbCGEBaCTgtYaJ8hBwbQg","DEwwFtVMzbUZaWfciCv1pgeZ7U9a3kka6a","DExquWMc3nLhinJBeCn1ch47yWt9osd98N","DEzbYBgWfQ4a4Z4tAdMszGMEAHc7DpF3ur","DF1KVffXh8C4ZwxGeYzsR2QkaFemLpDnUL","DF1RZV1gXJgvVnmZpkmJ8b3q3Y7Uo4YM2q","DF5QycEZffLeiWUHq7YohWAKshJPrSuKBy","DF8EMQo8hmzE2bwCkPYWpFCAmoLyTw9YrF","DF9GkuMFnhjfiqzWACzLLWXaFrBpfaTa2J","DFA6rUEN3DgAeUB37HYuNaQkZtSnTt5yD3","DFAopN5yeYrM8tn5t1nV5bi5RLopt5ZsVs","DFC6g5zyUxujhQvVicv9ShMT3bKjno7RsV","DFChjp2fs7g53uvhCk7JT2zVj8VgbptcFQ","DFEG5cenJVjYGUaFsgLS6xp5gLvjoCyi2r","DFFwai79FmWKmkWsvQT8UG3gGmR3CQDJsK","DFH2DwoBHJ2aSd6DJBiBxyeSJmD1q4euNa","DFKnpBhkwqLoA1hxrKkc5mvYgLmjs7FP9h","DFNBzqmCACsgkNvwoPyiCKd7EzWKW6Y7hx","DFRvdH9GQ1Z3528ai34qjJDQ5aMPY92jnP","DFTUVRyHYNvRWGCWhz8Rm6no1DrGeTXUCw","DFTWDjyZen7mYXBi9NAyzcxvdP5k3hdGfG","DFTspt2yRb2XWt8f7eZPSHzPgAPWm3wWfx","DFXgM2pKa3GUspYneasTBTBAyPpZNTxeYZ","DFYPdHyacNQNwdp5bEYbAujButMMRdGXLv","DFYg1jy1hCf3G2G68pe4pcik6YQhEDQYep","DFb9BGdAUYrYpVDkwcSHL2kj19w5BbMQUC","DFcm51CaddQjhcfCDAZFkyeCC23FZnpU9n","DFdZHPmELYcL9FT86qL3XshfbwYaLwoz8i","DFe4Kb3L9wwi1Vbeea1R3zzGL9whpmRjcx","DFgigv1osXw4tbub1FmkwhrPsYMTAva5XE","DFi9QBxCHMjnBjMZbH9xkVd5pbYsTjbabr","DFiA9qXaEUbTgeuqsp8D7MuTrKgq7VhzQ8","DFjMLxnR5EbX8Bh72QB6eyoxgzAxpm29Ur","DFkhGVKAwnJq5kHq9h6vihhTBuorJtbfTf","DFmHK3N7pPNHU6W2WqkcqzJ5SyYBqijRhd","DFoE4w5kwm4xsgT68RX6axYSeD9Dn2n27v","DFpTKgvST9noTPRd6s5S5d2N6f6NiVBokw","DFraKjjBHZurr8P54NyNASq5KbA31pa4k1","DFtig6sxNCf8ajr99PN9UGRLZ89vT3qbf3","DFuW4GMhybRDNxTGPSEsQCghvxU8P5NK1k","DFwgV5V4uHmKESzp9Dt6SdJhWDWY2x7EAb","DFzX8JbmpeSjqzM9kPYmuTBNdVrx22wc1K","DG1HVGb4NGSDXPdvASv3oqV6zW8ePjudwf","DG1xidTUQkCbLE74ykBZT2Fw1QHFnQaaxo","DG4XU7B2zsBLuY4jzpVoM6UUPTSbMk7rXn","DG59LRByerT6RojfPvKKhFnNrL21a5am4W","DG945M7Q2wgixnpFbTPWENuyQr4ZQi5NHG","DGCsrWJZ6VivFRE83FJvRA1MhpMqoXPiWe","DGCv1BRSn3pwoNpHCDifn7mCMsGcsuTeZz","DGE99Yo1S2sBW3pgJdfrQZzu7QnAgqbu1K","DGF9sbVzbzvBzmQeRUs7JTVWbRZrbbG5N1","DGFxA1WsEmgkinN1RHCpgr5qNKzo1uwt6d","DGGnL21L3XXs5urHHW9kXZNAFd2ZoLsEWD","DGJgQxSHUPW9ZfFFXQjCUrPXcoMM99ckUj","DGKGhyJgXhwjXNvEmrg78dK3j2ZVvGrnD2","DGKYgvYGasyA4LkPczMfmp94Zyo7tQxefn","DGMJ4BAbVkrmyr3spAaiydEiyC2WZ6EPxz","DGSg421MkpTGvJQi2cUNE2NMDFyqSAxr8s","DGSpm5FyGgYRU1pjQ4udRd2MQ6dLcsJsK2","DGSrE4PyDwg1Rg9KmXfFQG19RwzdnCviDL","DGTghXNwwtJ9i6XZ4FjTTEe4r1SW27ybaE","DGU87AsLdFrxz1vyYdMJaGFJsCNJQGdKrs","DGUahD9e1qCQLMuGQL8SHeQa7ayRX9nhPV","DGVricNRPZieFcsDW3YbvdRxDw3nyvzHhQ","DGYTmRcv9RfSDLZHvDgX5MENWR2ga1oD1W","DGYm65T4pWpg4UPCHcMtC15py7WW8Dms7z","DGbDXghcSD1xjD5JokvaFwU4761U3C6xU3","DGcZ37gWfYL9SHBZqqibGZXRphDxCr8h1e","DGcjFiLETH5vU2CYVJuvd5JQuASsnymGQ9","DGforjbqxBe5hxnVETH6Np8FfWeANXzZut","DGnNgQmai441wsQRWdPsz3U5j4WgEGtv58","DGofBNS9SyVUbxkw4UziNeoifpomq3fhcF","DGosWA55Wu52jVxdng6CSbPQxNtCAT65Ne","DGr4Ag5iCPk9Y1WSzmGQzzY1N9jbvxhnJY","DGwSTu3KakPECKhwCMDmpJo9qmn2ezgGzY","DGzo7aSxEXSf4KQerFfcGHAGgzgpY822S1","DH1LR3Ha9fwYuLtXjzEdi6gLEvSmFzD3ej","DH1WhPWjZbiVT8duxbcSDET4314A1pTPf6","DH2UDMbe2PUbr2KnQmhHoRnaKTg8rjGmKs","DH7KJRdDZCZ4TV23tE1kUHzyn8YTdjRKZZ","DH8KRfKPkjJs8wNzSwxNQBz8SRGHiryDF9","DH9PYU2NHWAzBw36eZdKGP4Uawb9GirDNq","DHAp2DTP1oycRBh2AJHt4MkUu6cjPVahDN","DHD52qktZmR6NMWA6azkZgc8pmRU2khqcw","DHHqLYTPHvwKW67kAE8EDpiW3jVJkDxavb","DHHuswspuRBHdpDd1dGobSrbbpJF5TVbqx","DHJ24RoMC5KzLuRGzjtYB47x2ds9n4Ldhd","DHKZJDtfZCoVuAswBTtAVBLDAZFnJcemek","DHQ7RadVdJLY5pZ6GmsYVEnozU5jY1ZT8Y","DHQWQbyVGRmREJT1XZ3nGwiNGwN3R5DZxx","DHQfmGPTSnXmFWV9nwrjuFGEyh3cJ24eTp","DHSMWH449V5jvbpHUGs2Ge7tJanukdJ7rJ","DHSPgxgoRC6fq7shDdh2nbwhrYvT65hQ8A","DHTphieZBY3KQHczRPPA7GZRdMu5gLTvSm","DHTzV9hDbiJifXFLpLMCQZJS25dh7qWY8N","DHUgki4KRjsFowqV69pLpF1irUXZDw5ekR","DHVSpcyUDjPYZq2Nj5FRvQGDeBcFjpivmR","DHVkdqMLBTRf6Urz7TfWxy76P9boQwRXRU","DHWaYEPMJnYuXKjsjy53dKiANnQqMCoWSH","DHXArGYMccBhz5RWWQR8nT3ez6CK14stic","DHXCW2GDsD8ti6QZJtCDBzWMZoF4Qv37xa","DHXCxh3xSaZymp2waaPYhfFhgjVkaQNNhc","DHXEz7EfMdAQpZBjYmSvfqtLtrFNk9AHaH","DHYHkmxnfBTTY98F72b5jpUPvieyrUpR2C","DHYfd58jeKfRw3BY6ohBkPpbGkKcnvBD7P","DHYo2ta8JL6n2N1h4aCMGf7j23dvnKtTDv","DHcF1f64jDBng2fGh3dUc1c9BbYEfykPDV","DHcFsC7Dm4h9i55y68Yyzej3YfYhfZUtSc","DHdRMzxfLFrJ5dhBuWgWTdVGj3Yvci9asa","DHe6pwuMnwWb56RuYczYJcVRUCbjbSfhCW","DHekfzWaCvpXdJpqQnDkmLXf2F27QzCRNG","DHgLY9iuM3aaVeziTFL6DpG4gjUVbrHyq9","DHgTagrHKpBYQssQ5pWVQKVVZJtuDGDCCQ","DHgZEw8aPVwNqLMureTVrzyVLQW67SPd7z","DHgnwr2bjb8tYvvZq6DjR82MHkJs7ey7Ra","DHhU3jg7zhUrt3tFXfstWuuD46YKuZBDub","DHmKKHp9AR4v3V3DYYVtVZrE4zKc1ZSwH8","DHmwiGd8xU5WuPprehuArD2MnzMyFG7jyd","DHn8PyVfSaKkWgW11JxUPtFyweVgkaprcS","DHnHp9Nppc63Y2C5AyBwLV8AXLU9RsGFbP","DHnpB3gdiyBQG67nXUxD8yPQhoPJefDZdH","DHp71qGRHinVTgNhsNX4gxMasVxcDJEs9X","DHs9oxFeKLVifibHuNKoKMRiYxZdFzX7WR","DHsndBKhf5i2RRBsE1b5wjJSCEEYqMozCo","DHt5vax2BJqLpW9x5SL1WCw8cxheNcNeAT","DHuaoDzYkBkeajxufJWJGNYEExttNUcVJd","DHuzL3ipdRjg25XA24DFD4rwWFSpyWSF6c","DHwaTtCw4Zqr52q49gc15hxWvtGspfQf5g","DHwhkTvQV8terfVbj4EC1kNayRonCLTSjj","DHxjK6ieGr1uTxdgFh5z4oR3sCbTCTm7EA","DHzgJtktaxJEzYYAEsuVWMytuNLzoRzRK1","DJ4MRrKos3fJc5ygMkbBARBcjdbeF38CZo","DJ5EFkztMExqaLT48hDbJShGAFcW9Xs9RW","DJ7UmDBqRKspZSGb7tTdZ241KFBmXMfM6a","DJ8TnUVDpB276ypU5HhextGxoUvFAeeqMz","DJ9T7WGBQrPrrHvvFMfUc3t1XJfYX9SjBJ","DJALA3wgeKzz8TptoP7xFqU1im2HwVJMYk","DJBqb95R37jwvrwoHYJx1aCzRSmLyLejrv","DJCCJUs9uvWrhv4my4m3TMQ7rKndQfQFvi","DJCxJuUKDCEJqmn6gw1JSTPJ3Vc5h7tS9K","DJFMSfTBm2teudUokTArRp93BCHFtWGEhL","DJFUZj2t4trySqPf3YnLrfmdWU3QqrwGdw","DJGdoh2veLz2LbqStaAEZhv8Jy9J1HQiKU","DJJj2Jz75D3GAJ69pmd3xwiBZ7q2ESAzV7","DJKYwDVNU6iB95uSFoEKVzMiCawhA9shyN","DJKd2Vwj2nhM7xb7h9wxGE2UqUwojCNu2u","DJLHeXEr7DSxv2Cw1dmLAfYFrsrR37zosk","DJLmVCBqgoXgNXqcJNMxomQBRwPxfVLpbV","DJPenEMfi1mi13UUW1QfedUnTQs2Q8Su8q","DJRWGpzerSDu8tjnSzsLrHcEyEypwhd4YL","DJRxegbxXRUdtmACu1WhyNpbko7zsmuJkP","DJSUuwcvmaccbrGtXj3xL3YXDEh7MKmFsS","DJSWQdtQ5x8uB5wM7ooQY8x6SjUYs5Zfa8","DJT6BkQtFTqQWw3nJZFVKSRUYJCZmkqprC","DJToCZrRGCE3TXyksuaM17TwvspJcJyhmR","DJXxeoqzmU2DW6EUX2UVZ1Eyb8HCNBdfGe","DJZHcaKM2wof6DjBm3YkXsJLunCN9pLqVB","DJZP6jgaZ8xgM9cumkRi23Byp3TddCz4x6","DJZoLhbtzHRWzmZ4egSAEC7Esb4uaZK15M","DJaUc84aydAu8xCmpNGd6562v5C2agv1U4","DJcNTiscZBKrsC1YxSg4WrNrEjPQLRkNZ2","DJcjKMMH6sTaGZSkEYpswdc2aWhcfc2Hjb","DJdqeyz8tvvJx2gt4MzLfWTWCpnYpGJr1U","DJf7Zzxee5pHHymfRXRavr34MoKmc2mgrs","DJgBporhMdhzjxPtmBaWGrotz8mbdCYksS","DJhVLXen5TuhsytvttV1sNhHdtcQnCK8P5","DJhuUg7LySzMFCfY3n5ke4WCrCdS4qbfN5","DJimtcvYYw3bE8Hw38j271yS4iD3XeY7QL","DJjYx325m4yrcuNXrDJbfB4PhhB8F8SRXM","DJjokHpZqYGNa8HG8AC1q11ZSSb4bDfUer","DJmopMQvHWDXrqCkLDE7JaG2yb1fuHhs2M","DJnhgw3TMCWNERJVayKhNWXo3kTSMGKaTs","DJp4Rwr87UHEeCRT5AZ8UVKjyBth2kWADf","DJpFHHcMaqkAcvT4pBnp5fK71sPwWuK7JN","DJpzB8yRrTDrZDoZQ2MNJLyFnSdBynax87","DJq7YE3zut6zGHU594ATYCDvv6bwUbnNzb","DJtDZCJpprSwRm97KdBz3UbGTdwVT9JHCs","DJtLL1ja3xCTbyUkgVHkbssPkYdhCvrZkt","DJthtqeXYRDMfgYebbLDorYyQtUy8zfCm9","DJuLP82MGpVvqdU2jprxNiVNCNQE7wnDbJ","DJvXD8Toc4oiPzDKHaH3PLm3WMEoQUDKoP","DJvzXZy9EsPnEw4RWZxLS3qzQYGpDwyhnm","DJw1Rbz69hvWgfbKB65VcxbxcVkGifsdF7","DJwpqpKAo1V9bWkNFJPCrKLtqeG3dfWCae","DJyM5K39qAxXjapxyPGCsok7jpWvwWngXj","DJyRtQefSCR1NzNq4UXLAATGPJoKRJMfh1","DJyULcM9PT8FKF6L2UXr7nqeHq9a5KLMJp","DJzTZnJWvFp9h6Hao6xtzJT3gKCxATXDuP","DJzzJ3ZAJF5opELMAbUq98K1FYGCh7VcUA","DK15sWMC3PSyYyog3673Rqavf3eUehuKbh","DK2uKKkzwWdn8Nx9Gmm7GarHhHfQhFuY8b","DK7GmL6wUiHWfqgQFWiobwNdyzk338Gsea","DK8KsvcXP3rmdQF9ZFkqc88qxmGhdiS23Z","DKEw4nrWn48sXQ7CMhrkCew9nZvZpvMJDH","DKGdC7mXLAHHw5Sy68JJPPHvim4EiFzLnd","DKHJNbL6B5aW37jXq28WB8Y46ZMgY4mbR1","DKJ6o4Ax3zcTqsPhihdEKbDybGDKwSEXYJ","DKJGT21taGubWqu3NFYueaqP92nAcp5FGs","DKKTxjxhkAUAHMU22R2PvhCED4VRhZP6hQ","DKLYJ6MqZtpkw7p2oV53aAAT3VPQWJeK42","DKMSG8acx1fms7rUm4WqE39SnJCH2BBbnW","DKNDqq65cZAyaES6gFaoS4NRmcwQJhRoAd","DKNhdC8ShfxzSVV5VTQctGHWYhD67v3zrG","DKNvtyt7WRxxL96G6Bkgu3oTnkUzUSEZuC","DKP38p3AeYC9d9Wr2idpdcPEnfXPpwWPAF","DKPokxQqCzxJBg3kQKTXHuAMxvfeXT6Kjx","DKQiGCqPAUErSwNQDes6YDJe2YyJD6d6oc","DKR7DZBqo7KTutcUqou8RSzb6qj3TkzEaY","DKRCpednefaeriBqQgW11xf1SLrjEf4atZ","DKRtJiZPRFhyG9MTCvX2JWeBLAkP6gGU3o","DKSST9pRAFHkf46R4thGBA56tJT9YGkxTs","DKShSgJ5TFmWce37yKhTg2ySiFG89Xzk8o","DKU5avWr2YYP1cX3KCvR7z4xt5HJLLVKv7","DKWqBieVetqyNPiDYFdh3QSDTrmb2uaaLx","DKZMhKKogaD3bV4isH67uWhJ3s4gKsjyCo","DKbaBLwbLrM5tibLVCbN1DPVPwqdKX4vHJ","DKc7NQFwabkhGNxduxSvJ7ir5GgeC5kvbH","DKcDhzZcC8jfCvC4gSgVz8Bou1Df6csQSL","DKcTW8TakybVxbQJvjfg4A58511ubo8iLP","DKgNeK4ES3vK7MHN936USKeMspden8a2wB","DKinVZoiphfEKSDevzbt7od4QUPZF8KyeN","DKiwjydyPQQSDcHFz41DxXswxFbLycGU4c","DKn5Di71ctMjnv1YBwEJZsKsrWQcRCBWzP","DKnxTqnWgDiS6sZRp3HY4w9K4HBqygwgoV","DKoVdV1tU97sj9SNexmEHu6W1K6JjQPtEG","DKpDUspbDAGk3xnoYaSiQUnMjBZR54wY2N","DKrLVm5MX2EEk4rEDtSgqumfnn7CHs7fo3","DKrgPNBJ4dTqsAtF6HJ7yoxyBs2TF4VXb8","DKyrXmMtpFCmTpdjUYQJ1BRhoJMZT4QqTg","DKzz8FhUSC2qWV599rKx2K479vvZMKXaPP","DL2NaYunt7SLCQD9jvB9mUadJKTPEkGEAK","DL2VDDhRPkwsNmQz7BobLEBcr31xXqbyiy","DL4pyL8rTM4wfW3eR9sufdUr6o7j34A1YJ","DL5HcPaAQG6JHZP78yrvq6HeyzbjdYR7CR","DL8joujRyHknKN6ncqG9BE9XTVG9GezskE","DLDgumpVbwVWoz4RF5Szs4jRhpPzteE8fo","DLDnWK4qRqRxSCio2AcuNDtht4yFhkQ1X1","DLE1Rs9wGz2DaqgDdxinEtbL5wcAAPC5SF","DLFMYpSWXYocQHrQ4NyCFe2BPpdgXbinmM","DLHdmnwkvobkTzWr8x8hSv6DpT4ZWAzgPK","DLK1s2F2rY8cXcg2RNXACyhWnDDo4KzDPH","DLKyoYkSDqmiSRTXe2aVmmk8Ek4QFvzBxs","DLLaA4na3WoqN5BsEHJBSsNU9q22yRsVPx","DLMoHU6ZfASVUGyjXMatakoCq2Mu7pGG6a","DLNcjQmNUpeuhwVjT1VPekFXMQLN49mKcJ","DLPayyKgsGWG4R1fFxrKkFUB2npZ1VnPB1","DLQA3sPkeHqEzcEwu8qtCYs5vEQiHUjpY7","DLQJAfSmgFJJG6uh5YCrdjt9ir3Ny21Zno","DLR1SFpToifdoc7zM5VM3A6riWGCUjm9ZE","DLV3s4vRYXJBi3mQXH9o6KuDGNbP5hKSVU","DLV58WV51PhSPdSE7ycpQNfL8TnetqE9op","DLWTpBimrrdQsjw8oWiQNSiLc67Ezx4Dsr","DLWxfyYPoy5uBXrS1hyNLHBoqJcmdb7pDS","DLXf9Ck8KPsojYppUPzVemEYWNdEzSyehV","DLZ5b3rqtDydcn9DDFksKHWh5zWEeswiGX","DLa7fiaAvCt49CdA7SwPhrKEg8urhCUQYQ","DLbgLnofNR9E3PZdP9CWHyaAEqQhRqnp55","DLdsqS6c5k8k2sdpFhcD41tCQmEnMMFLKQ","DLeGXQwZjJFV6Xp6tiJpKKg2LQy9LUDqrY","DLgBCyuTaNdcpxpcvWLy43GW8JAGY9nTEG","DLk62eMAL2pFPQmgUhKHVFjTBxHcFv6oPv","DLkd9BzkganvwPNqm7NXqhC4YzjJKQSWrt","DLnJ8dwghwHnV5sa3r7164cky8fnhcGZPg","DLp1pLWM3oWGP6nV1TahWSCMBNyfX8gVsy","DLqJAfLoQ6pDhxojKuxjHqxuga7KpwcZCj","DLs5PBPujmyLJPGudH2V8sRfLiCKt9VnHC","DLsAFSCdAM4wkzR54Nt8ptCioFHW89KeBm","DLsRY65cmsJZ1YHcw1hqjGusz3QXppoM3t","DLt5YgiYtPZXxhhzHnMn5caHih6rW6ZoCR","DLtKThgru9tsuzdF4js9VuUcVczieXJyNs","DLxR9r4NhrsQ6AZFRe6xLHhLkrtwtKoWxM","DLzNwYuzzcNXFBN2cUR1j55LHKx5fWVy7N","DM3auPr786gpnGLs3RcYA4wZvxLVNnVySr","DM53CkNJHGw65yhFFeXkypLub4638YeCsR","DM6AkaEEVf7rEQ7CVYMUtn6LBtQf1pGohS","DM9WMCti1ejKsoP6yVRooGhVLKFj33qrTJ","DM9sbRLmpbUHNr1PSpfTt7tQYye6PL8ycj","DMCAQ4jjh3Xd6THaqEH6TyrPUEaC4Q3pcc","DMCNy6n8M2vLscE7JxJqLNf1hN1Xbxa1ci","DMDLJS8QGSM33ii6p5Udd3wWt9kFSY1iUv","DMDVDgJvkY9J3238kBgPPXuPzaxnh8tRjo","DMHSuUe7sG4R2Hw6aYTFB3FRxrvpS85rLQ","DMHgLgDKLTuCB56HQgdd7h11VfdGifxudy","DMJDL2j7nu3sPnj24EYVeEockfjiWHWdUd","DMJiRy2t8QJiYKe1VHKLLChsBxuGJZoP3e","DMPXUcu8uoUd3e3YFpCnJm9e3jT54UwiXT","DMT2CKcimvS3TvHwThB3jG2Yhv9hUkiKGb","DMT6iUdHQjqDwgggHmeU3aSeKMdzKrJqnd","DMTmy3nR8hMBoS3Bdzi29A2DmzvWquBBMi","DMUHpiqjp4RiySUMFYb9qKdAw6qNjnKnLJ","DMUsaDgGUTu2ubYUeHX4x7Xj6SywsHt4f7","DMh2z3TeT3DjsvMrzwgjt2uf8NyndifA2g","DMhUoXD6hKUgfFkx4JJEKop9qRsdWy433A","DMi8iLceqWewM6YQdwqh6j6c5PbSGokjJN","DMnHUegrMP9amczuHLiByqzR1y5zj9zuVe","DMrCjz8gUhbN7t8BZiyvZXTK8yCFj9PECs","DMrZvcNKbDUkrVC2EdbofeRdKoJhqUw9jW","DMuS1djei6Ez1ywAw5Nv6fGsnFAenYyh2o","DMuW5JR1xTtpaahwVj49r4jfLhtMWkq7je","DMzuoi8QwEgkUcWeBphs3wrGSuoSUttEjk","DN2Tvc47YLq1hs8cUV7UFkBRwMg3PruoKJ","DN2U14GFYQG6neMKygM6ZTRN37TwsVjCN4","DN333czjcbKBPrcQmW19nQvmtb4f1ERrGB","DN37bdF6oJtQsiosrzq13HgdP4EVuL3THh","DN47APKPTHaMxj2uFfv16m1TNHwsFT6q3s","DN4CYXUTSBgNRVzDmkL2dyrZaJKbgWJ5fd","DN67XXtd2R6YsdvkdXhsEqY2AYKAqh8HUN","DN71zytXLjpxHQZs69cxQ7VQHXxVxmjLxg","DN7nNPpW7VVcVTrW1yHhU8ZaCW6DgRXm2q","DN83tw8nPoxNBaUUrsB9GnniEH2xi61hGK","DN9NKHjMJHvn4kfXJ5FMNLMrNov25jLtAj","DN9Ywu4mJXAhMD8iu9UYk5odwyLAp3y3Fr","DNE7f7Qdc6EfCsKyAPSZoeUJWpoq4dk52L","DNFVfdiL7uxyccTYoAGkogtwUc9P1bXVYY","DNGcri8XawU5EWCZD4naUhVzpygGoC4aRp","DNJKtBGYhrCHxbFZQesvQa2eeRRfLygVpj","DNLHvS2K3JR3w5tDcSNFBGRHz2oEvPJV9s","DNPNQUUMYLcVwmnnBoDqdxKBBgip9Dekc3","DNR7GjpzKHVB922d9NHv9kmuSvBUfSua8F","DNSvu1CVPbrjnT41rhXgk7wqkpjk16H3X2","DNTw72zfFiN6ow6TdbqT31hLcJWPKKXM5D","DNUSVo5L4P9ZoHnzkHNF4HnAPA2oRF5hEP","DNVps2vmZdk93yG1mSKCiFhMDenwkdSQRq","DNVqsCdCWKATrDqmfPfNkkoPVf4DJ9aR5d","DNVrFG5rSubfNgj9fLAYnoxhGHJZFBMAcN","DNVrzavCq5f5PvCpKbmt9tW1FQpjSiJkVY","DNVwxfKuRpQzh4LWdbQdHK6qRppurXTucq","DNWUCFMcyZ3a7hPqYYnNcZDnwrKrN9vvFD","DNWjYMVuUccANXRuBcU9iacxwgn67Qaavi","DNXpqHFFvB2Fo5QyjjcYerPDZeqH2DppWS","DNYEsKcMhhGJoL8HPvL4kNhvX9vSKfDTK7","DNbhvXzrFV4wJhM4wBXuo7Fdb59VF1Q2Qc","DNdmKcsCBvagnGcDxPUuCHi7NwLUfZS5HM","DNeG25cz5RXHCicF9ob34uwUMAR7SWgJVY","DNgRuf4dEih3e5kr7zKRXNnk3e9xkhfTcU","DNhhXkaky3ekKQSHdK91qwqxYJguDvb1do","DNicLdbczn5uHhRdvmsMB2MYnQv4Y1tCjB","DNnMwr9JLtUeA6RxHg6ZHoBHw8XQhewf6X","DNoKA9jgGHDrkSVPRJA6wgTYK8FrQnoNj8","DNoRgQaa2tpHGzLZaejZFGPqJZABU5VHu4","DNp5EspkkfHJwwhrWpqwcCmYfaMMXCMM5b","DNp619m33sYxMG2bv37Bcx2W2ioXWohnag","DNpQoXyZLwqH4v1FDZoCkRD3N9mGxu4WV2","DNqTMhTa9J4fAFAMDfvzBqk4iZSR1jSpcF","DNrHtgNtorsg9MwvLoieHLmLTNfz8qUt6Z","DNrfdrv1NCR83PiqwXZqMiMABc7PgqYnzE","DNsDUyd9GZ3pnztzCumDfayT34jC6UA411","DNtHU3usaBwSVY9NtZoufGbC43pdKnfTPq","DNtkuJbi9m7aHoGbPmwU6yFbmHJYcFMFgf","DNuPz9huAEzSvvGP7zPwy4383iuHvGaMoJ","DNwPWzTQCoZEGR1Erm1rvcXQxHJXh9Xeqd","DNxDhutpXTxHtqfKU7CEGzB584PY11EjKX","DNxuBqZYXkQpaKXvBYK9UVCDYHsMaitrB4","DNyWVnWSRrg1T37xCWMbwdXbCfD4GyMYT8","DNz4qSKcF3tCtP2YVJZUpjCvYpjZnWrJwW","DNzjXCuvC9g6AwQnw4XREtzEFJco4K9AvJ","DP22utdo7i42WnFZ9BskQ34uvTC4FTKepX","DP29Nr2jyd237fwh8fEq6f2rNbCd2s9jTa","DP2fahGrczGEHA2EXh8sbS5hGLQhRF4ebw","DP4gMVp7M2cK22RU83yq2bv1DCfUcdKHB8","DP5MMPGuREAT6PJM1Hi1fayioj7DTZtWEZ","DPAV4MBDS8Y4MUGScDeLsTVjkKYjYVPfzd","DPBjf35f6rL1sRPACHSobFgRUFBnHKKkqW","DPBnqJUs4drC2HYqgqaKGvd1EiBoLa9azV","DPCUHbBPm7KTze3cGrMBBDuVaAaKbsPKMZ","DPEML9uoNzq53u7vS26ZAj9usMvGmxU9Et","DPGPZmC3gnXkXaoUMGKQZjhUVcvRhjfyLg","DPGr7A9jfSPdkEJE7gFbrZWcpYhUBk5wXR","DPLbfd6EkKWtAekWbVBGoJ9r7193Qj75GR","DPQ86M7mpwQx93RG1TQhRjFBP6MmL7dHej","DPQ9ycbaJyvPzCav6Zz1i3AUEze8ZFj1b9","DPSsdgk7Howmj2FiaL18bQSFCuQGDMqGyt","DPUva3xh1NTs4YAsPYhvMKB293U6xGZxWX","DPVR15jucwRQCxApcgYNJj5CX21x8xFbeG","DPXJJypYz1Yrx2Bustji5mYbfSDTUcLc2g","DPY5ZuABi2WJKe9Sx1N1WXQZbxL6EQ6tNL","DPYe8APAsej8m7Gio2n4DiVD5go47ZZbnr","DPauqanvJYTGn9sjMVZQyMAcgopFKnV75o","DPdKp9BCuvsSuTnjBGfMA7BrWAZHEZ4SVL","DPdQ6ArXqYnMnubiuJpJaKJxGTZ6B6sBU1","DPdSMdJNK9oHq8jLkoj8rhX6WFVKWvKN6r","DPdiGzQ2Est1XyEwHvSC1fM1fCvN2dngSe","DPecqfYM3YgSSfg3KPbDfRALCq8RgbGP15","DPiStrsSg6qL7e3qdKCgt9LFJofGkQd3k2","DPjJSyo6KHu6jMNHRj5sVtc9neh6DWm5w8","DPkMu2aYFQQFtmHYsE8EwMD1A8ewgFthDQ","DPkbLXmtAMfX8hMHRrUcnm4kVXQnT7fTHS","DPn2EsYoDfGQ9HYqV9g9Wj6CdEfbHqoqQU","DPnbCKv88hFy5oXdM2ZZ1CvGrw8WSsk3BJ","DPnjyU2VDqe8xeCsEjmZBv6STFf9vhgsiY","DPootSZqcaXvjj1MHuj3Yfw4rVFmU8i46o","DPp1FgL2ZGmRmi8mYG5v6j4G2krk9uJdoo","DPspAUb928NUP1S7Aae9c8cVkRCuCBvzc6","DPwqLTGbDD9NpafxBzUNigQpVmnVJPDxAB","DPyf8PPmftpgvKzv83BuEVAXv6qv3hrjdM","DQ2T9d1XNo3kWp1EQqvYfizZjhBZyn84jx","DQ4mQqjhrrmMpMiBfWKzuUqcMT3RBQ4vwz","DQ5iH8LoFnFFXY4UYHy4mayxVSaRJjG15K","DQ6HVDELEyAoww3HQCJYnNHzwnYqXXhkLG","DQ833poD4ouzP5Tm2ipM3u3qx39MkBG35X","DQ9XkND4GwJYStf5Lj7oDhw3gFUa93NWxm","DQ9vYU4eskXKuabu2paeRweEMJi7ZVr6DV","DQDXDXTM4vwxcJZX4KtFAGfWWgvPoatQVS","DQDyM1XKjtUPzXEeDLVUxVY4mabyX7FfzF","DQESD2cppwRHkaNijui7xM1vCuj4KwQFco","DQHJX24Hngyrm7j2ZWdaiXtKKxdAtqLjPP","DQKF2cqXnEpBp4v8rifcwjNcSJB6tf6i37","DQKNxfaTUwnEGzFsGWkpLAJNN2YazojgE5","DQKhm4kkdQBx5k8JqYsYH7xwds4gYywRR9","DQLatPBLwkxormq5EnSZCPTR8X8VYCenDp","DQMxG9podoiEkkyMvgoe6E7Ea4sr82q1jT","DQPM76pFxK2ADaxVSoA2J5fzDmYbYrtom7","DQQ1oVUBVb4TWFcKFafyskpFNmNEkdGuaf","DQSe4Vj23zAw5KeoBg6Spji9GDL7RHFLkH","DQSy786oyvGTzuLSGW8VWUNwQUbMAhMDdV","DQTwJtnWUCRgCL7izX3GHV6ZG55KchsQuR","DQU5ozeWtQAPxK99i4gPXBJv6vPxndNhzP","DQUAj5c6ip3whzZKyqPi7YejH4QBMXo8H1","DQUbM1owHDDM52Z81uM1vHLHyxNdoCPvxu","DQUdLmqQSdVmHsx9nNXj9gM6GuHbTHxqt5","DQVygjkc9D7MgevGmvCpG9Xos41DsQNTMb","DQXPmAi6giDKpFWuDusxmiduy1SMdcRXB4","DQYqvzET8LgspT8jJ4odVx2DG26qgfqEnG","DQYrBb7LVuG1mawCWU4P3GfnHYeZmLxzG4","DQZznh32Ss52HDf8DCcaA2QY2mH3Gmt7S8","DQaEf31n7LSoGwRvRX1s6GczEJpoZvyMRo","DQatkU31vpDrZmJAFSjDRSZmMmdZqmqR8R","DQcaXdty9i5zFmrXzaBjF6a3dtTx6sL1sj","DQcexJD4TdT65VHRTkr1saUj1we6YEqkGM","DQcryP3mSuLGA7UhBJWtxE4wnH5NZKvsk7","DQdYGXrzJBTpAbvCnA4bbQjbaoDy8SLANp","DQf6ikdVhysMDkFr1kYSe9F6u7wX582SYA","DQfifsh7vJAdLTzeU6vWQ8sjDG7Yn7wLMT","DQgQsg2NYUTXTy8tQnnUK9fwHimk42BQFd","DQhFbSNeM7mdXmnVKKutEHArqR9hAALMJX","DQhZG2c6kwA6SJQQTaSBPBTS2X79KSjiLw","DQmEY9vcQiQrB3WrUxiJoaFLsVuxocEp47","DQpLVRbtFtAjXxkJ3aKYrJs3YmwAxBsFQE","DQrRsi66GZw38czbKEDwfkoEG6wP7C13X1","DQthkc3jRxvqqjPUZfogQmD42bJaYiL5BZ","DQzAJnXNiEEi6U93kE7AaDwzWycoGs1ge2","DR1AefysqHVC44959GJfeG2mJD2WXSzzZp","DR7oXWfSRaAVu25gPLv3qRZm5dx38UrZ6B","DR8ktSeSN6xorndUYTXMrazhkgHFUjc5cV","DR9iigG1xrSNsbiE9FUcLq8JvtN3hgtXWL","DRAPJ5xoAynfxVBiPiMXZHk7CqEG1wEJzo","DRBoW6DVf4tRCx96Qo4Gydq9qgCdb4NEMR","DRCKjacrSGvL6cAs8SK2DgdU2wP5Ze2fHv","DRCStqrwDJFUHH8mYvBmhJ5UW7UHhwBWZZ","DREm4ZewmVck4n8fUcUw3RN3Sg9Uc8U1Cx","DRGWbcQj5UBPMHZhQjGu69LWfNhzPQucB2","DRJMgsEVTi5x2h2Q151b2zeAS78eSfxvEx","DRMa6gSz7hFkdCmtZus3CYLQpc4SkkmJhW","DRMp8vnUipdZH1iXjX6P63bjj8V7kCy7BZ","DRPpbVTwMVozd8shx9M8BFoVmn3Uai63zj","DRQNUH3Y7fNCrxxzEZME1VA6sarRqvgY8d","DRRJR21QvYijAzvPVDw2oAs826Z9rkz8xE","DRRmQJELhKqrzCkEprEfJeYHU7uF6rqCoP","DRTtRJnQzn16FpEiU6csH4qDiWRKT6JnWo","DRTti7MD6nzgxavnN6z9gapQNH22Vb5kUi","DRUhYne6MaTRMKjCA9SdWcdcT6ARWqpJLB","DRWm9LfxLZuViq6vLuaMVHgem73MdY5M79","DRXB4mFyANteSBosdLTkh8pGacRiHkeV9Q","DRYrVGnGBog6xNmGLVXpUYpxhcT328T8vT","DRZevpNm2Y1YqSouSr7c9dfZefpQ16PhAd","DRZvAdNDBuJivrSg1JMGtoZFUF7NrxtZG8","DRaxD4Zf79g5jRaEXKVLkzLFwFTv4xQ3hd","DRfFrEQNRJF3a14HzYEU8jqZ167Kpeibh7","DRigruBS5gj7SCsZfzknaPKvL2Z9xmfNj6","DRkdeUcmqqNox2k6SdrFhsuMCyfhj42rom","DRoHsknhpU52abAhJyfJrZNLy824TtoLxd","DRocfzR8KgjmidveNKidFxyEFQvK5AcKrZ","DRrL9tmFvMhVPaqEP3hvuAUtrRkDpwy81h","DRriDkXrU1iaqiMzDVgj5ViyLdzENBSBjD","DRs77SdfxLdFxzFhet5jCVqCtTfJX5P6Zo","DRsvsdnt8eAy1DY2gLA4JuzosJpoMq7nxj","DRtGZjwYfyRJ1puNpJs2DtRwx5gWyLe3kp","DRwMXpBv55iMCuSGncM1AAhqkiZaV1Cxfi","DRwZ8RxsiuKHQ5F3fzWPmSyt6HVvRnYJ8v","DRwq8EqzfJeSbp9hJ4VzNc4v7JV3GvDkuc","DRxARZpTFTBFav3vMivyyUVCCT4Nv11VMb","DS1CUUhPJkS3fo4mWBRDr7HEQqupmVorek","DS2UEAJLT3smfm5gQE5KvQGvQS1A5A8P5E","DS3ozz1MWTx6rC73TBJreoGZwDN1ko6jRG","DS4At8tZMrR6pc57ejgguQDNXpJJP1V9NJ","DS4oduUj9S2gcvHmTGoNfc7fciinf5wZ6N","DS8DrKrfaKJyzrD8ECXGqQ5KnVXyNBkkQf","DS8vhmhqPVHwSiaTLPuV1nd8AwDU9gMGTY","DSA1LpDtZRe1SqLbdwvbqRoCD1BGQNJpGx","DSC3GZ4kMcqRsRyFmuhi1GuDo2nzL2A2DV","DSDFT1waGAa7wPF116urZjpGX6uUsEtpUn","DSDcPNisQXE7Wnxv2rnGN5yfwKMF2TP22x","DSErtMhHvrCDJD4Qt7vPk99hYn7mdXUXih","DSGGmmQC9jRJ9mXjBMdgzANyuU7edBB15U","DSGLuHsspxbsGzzJPvzNesJMDwLqm28zLg","DSGWq7pTBLx5LGC7n2PEqRjuHjWazcpUCH","DSGiRJQa76vf39tnHVLGTrUBQTcgn2UvpT","DSJGfmAA3sGPXFWjS29kCyREH83XS2mieF","DSKqnSmSpKi65iAzipdJKQHW4CKCcZQpWY","DSN3wEoVkyC6AkC3f9G3t9pQChD1GYcXFG","DSNZwRcqt5htiP2aVXA6YXmPXJDytiBDHG","DSNzYbYc8Vc1udnhvdLNWqSTFPmzKhk3cX","DSPVy3goieJcqw4TkScrDEcF1XMU9J5qx2","DSQWHw3GbxQqg6dKho9EEUJczZHvTcA1Mu","DSQafHDcPHF9rARFH86shfYw5dm9YqDRKn","DSRYrF1ukPpze4ATE5hKMZahWdSmS1y13g","DSYgmMxHGuhErxc74SMXNDaxyUAX6hjyBZ","DSYjUmATR7KWMXb1yUP4ag2urSicWNZ9jJ","DSYpmnpYa3gfgKMj3o2WeLd56jJmkkBNuL","DSbgj85WhJZAnwFNexSSrRqSVqgRgNWuEf","DSexuaFbxTavEpBfX8EVcgofYMg1f3zkwB","DSfCGfN1D9wvmLfUSdS6V8g9tXiizFRnii","DSgntTtpf2G6uNB7Ri7qdp1bMTYu3oAKa7","DSiknNVa8XVVEaSMs5hMQE4M7BJ7F4d2Yu","DSiq6zQ1qjsahjdE6ptvEJBUEXMnqh59d6","DSjqTkQDN8TduoRRnCcrw9kufAEyuDKegs","DSmeM3XjoB83VzFF5Z8zRaAMsXQXAFZeBq","DSoypY4GmjpHirKTAGHhtRGA8PnZHWjFeB","DSr7zS2hMsWReviKrcWk5KAhKB8GeEtXFw","DSrPz2PDmRtEo8VH5U6QyNnygjrFiQB7kb","DStdfq2Gx3B6jjRcQThrpjRaLeTe577Poj","DSvaTyYwAoXr2ymgPxNb6j9Mmd4MJyCooi","DSvmGARmtDBXDeEii78fY4sBPxgb6AU1Ey","DSwNg6VPFVowtva8XT7rx1XbkxEKsEamSm","DSwcS14Uu9xcwigSXQNvSRUAFAHK2zibip","DSwfmELe7PJVrsf19AKuJBvJGkJQqFN5aE","DSxAvN5frKUskswxNoHLK4u97nj26jB7V6","DSxowGYjcEGvMS3ebyVERpZnjuxfrpjRD3","DT1JRYiUK9KD2yhYVCHVEybkmWGwFoRmuK","DT1XRbBPKRtu5b6woAhg49ezN5aDnh3VcJ","DT2yGE1nUswuvPJ9gKxePgiQ5NamW5aATE","DT3KnGDe545pBip9KHBKEzQP2QLXG5W8sX","DT8N95wgWPXAvyuKMmhEHYKsx4UxJVetjm","DT8zmxTCT4Hi7XmXkCL7A2ym1vX5nanse5","DT934N2bbXarrSmPSe7QNB8RqhTs14yF6P","DT95xKVqpXYs9kkdejxDacuzToisNkkNTU","DT9xLD1nh4hYRqV4uKpQytw85qLGjYmjK2","DTAAgmADhz8FANjbaFRERaqdoTWGQoSLz2","DTBUhyz3Xe4QmL6v1LHsGyDNz9stSfQdUh","DTD1F6Dv2xwmo34XdRNeUZjFBEbnmPqSZT","DTEi3ntyhZzi5egtYK1AiHNV7TRtL3R3ou","DTEu3txrPhrk1hezJyk94r9P7v5mBP9jJV","DTEwsvRG2UMmTtC88tR8bUNsGUTsNifbwT","DTFcdKfgjGAw4e65dNxjzkCjeE4EMFi1Ri","DTG6ojakMepdzvwxcr7KscjfcJFm1uYhnd","DTHVZQaJCPkXY3rCF5YqLJC4ai4xjkjwe6","DTHidBkXsGJZHjZtAeMB5RfmBViE6gjtUz","DTK6SoFmU1hAiBZky5zFYRuu7BEgn5wNCf","DTN4uUU6oEmCc5Qx4fGrSrCAQEpnMCVxvk","DTRFgBqd9KfHLMa4xcDeFsjgJta9VVCSsA","DTSvTsfiLc7zXpQchHNmN35cVo5vdYEnVy","DTU1u6vLT1xkyW2eFmwXYkwR5pdZk2z5VS","DTVVmmJportBf8v6sip4rgsqzn9E5i8PXz","DTWhcrSBbKWwhjEdNH4zHEJweU2FyKnHqa","DTWuCS3N4P3FtArFKHxAhYghLWmqdRtqjB","DTXNYGjis86F36akRtsx3Bh49RnNBPsuFb","DTb38H4XppqwnbiTdSUHuy3StUhWbGdD9D","DTcTfVg8GKRXeep9s5yWqb7zmQtfoDUZ8P","DTce9RCNH1TBSUopH9hcr8MY7Ttq5EZP9W","DTgUEHMrATBLhbecTV9xyqUd9wF6beRxjH","DThEBmMvoV2gGbwVnUS9E7VrFsBT6EZKyc","DThZDSuPghUwexLDjau6Mx5VWxRqxdBN3q","DTi98T76HYEmdr26CzKTRw8rymRSx9GW92","DTku5uTSt6poVrFykjsBoEc54tADs5ahBV","DTmJuCMUrA1dSk7yDnNVXArsScNYtxus9v","DTnwFxBY8jhSzfJCNVhcA6nJEbearZ69RG","DTpGPok1vPs692uujopMDNbbyo3WfSLXjB","DTq53NsxpEtsxEx4uNiGiY62z7tuKj5Eha","DTq5JBgr9j1wBCKcZtm2qZbjptwa3eKG5d","DTqA5gModKEi76g9gjyNr6rMXWJ9aNMtcf","DTt1vHk3hUZieTbhsooM4nWL1uCZv8Ta7R","DTtMjv5vWYwoCK8KhUPiVfKanPomvQqLzt","DTtPvvcmQB182JDRaaNmC1xXUMfMWGxHpE","DTujttNkpzHarmkpx4hVUccxSFWCLMaEir","DTw8Cfsu2k4V6sAkoRLKQTy6nqy2DZ6EmE","DTwLeGrQRsfRhToszn3r2cQq95Y4627V6Z","DTx3dfuc2TR5QyszrKq2v5fR51wwVFHRgG","DTxJStAvXjxHuqjGtcpDi3GG7UM6FnDwUx","DTxZJgveD8bDoMvw1q8h24XEoAxH7kxJyy","DTz6estEh7eTPcE4MWzVoLGZpP9dZHM89K","DTz7Njhe9AddDronYRJwRsc194Fk6ospex","DU1sCbLyiinxfX9Mxdzh9TZ565K2XDJbaR","DU2bwLuiSPY5DRGY9CVZjgkx2nMekscGUj","DU3S67VwwYuiACBcUjPuXwCxqfgkmvpeEM","DU3ugvfyNS9fTgrvurCdU7Pk4LDpEhofHx","DU48Enub5nLyqsd4EcGJa67cuK6k8fg8mo","DU4rnJ8VGhgcLYhp4yA42Eyq8uBAhmA5XU","DU6V5m3G7eWwWMjDwKZwgAE92qoAvNevkF","DU6bZo3dNhNNt6Kkvc96shEhKTEXAZJvYS","DU6h5dzoXJGBcFpN64pnRHWSNfhGrsTpdo","DU7x58y8LMptHBJ2JF11c692GyvKwKT28V","DU87DNxycirGBCbkZ5PEcsfwqd659ZoLXd","DU9g6tp1ALr8PqxkW1Rn7xue4uAAbTmxKa","DUAaeVfCouEQsQA7hYKgrwnSvmwC6Ae4hS","DUDo97T3rbYNjictGihgKiqwjpGsZE7SFu","DUGcn2fRUQQMRbzMdM2g2p2uYfeH2EhHsy","DUHSPECKowdnhY7qw3Kx9mD1P53HMCiBKs","DUMdnR68eZ1WoE5GDqV9tddeKeUDGTsThp","DUPFbS1QfQWV1rLZweJLaB6VhqDH3a4NDz","DURuELuKGSvqCjZEzW7rUcPpSpeV2ZS5ep","DUScz7FdmGUsWEZNEfZseWWzegf9rdEmXi","DUTBMHJ2fwTFrT1KpjtycXTQfHMrHH1Sfs","DUTfiVpnP32AzWNzsUdSTV99hDsNgTGvby","DUUfcwZRJxFBT4xgTgufD5LQpV1sumBkUa");
foreach ($possible as $address) {
	$current=getAddress($address);
	$values[floor(10*log10($current*50000000))]++;
	if ($current>0) $filled++;
	$balance+=$current;
	if ($current>$max) {
		$max=$current;
		$maxAddress=$address;
	}
}
ksort($values);

echo "filled: $filled\npot: $balance\nbig: $max\n";
file_put_contents(dirname(__DIR__)."/stats.json",json_encode(array(
	"pot"=>		$balance,
	"jackpot"=>	array(
		"address"=>	$maxAddress,
		"value"=>	$max/2
	),
	"odds"=>	$values
)));