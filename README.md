# DigiDigger Front End

DigiDigger is an on chain lottery game played with DigiByte.
It was designed as a fund raiser fur dgbat.org and 5% of entry price goes directly to there wallet.

Programmers are free to make there own versions of the game or a whole new game using the backend.  You will even get paid for your work if you set the SITE_WALLET value in api/~server.php to your personal DigiByte wallet(only legacy addresses with upper case D prefic supported).

## How the game works:
- The game board is made up of a 512x512 grid numbered from 0 to 511.
- Each location on the board is mapped to 1 of 1024 addresses at random.  Mapping changes every 60 seconds to prevent users from making map up.
- When user picks a location the address is checked and if there are any funds in it half is sent to the users wallet and the other half is moved to other locations in the board. 

## Notes:
- ~libraries_src is not needed on server.  It is source files for libraries.min.js