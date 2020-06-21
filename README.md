## Web Security
My first HTML project.  
Secure website using SHA256, DES and RSA.  
  
### Register  
A user can register using password greater than 6 characters.  
SHA256 was used for encrypting password.  

### Login
A successfully registered user can log in to the main shopping funciton of the website.  
SHA 256 was used for decrypting user's password. 

### Shopping
The program will use DES to encrypt user's credit card number and RSA key chosen by user.  
RSA to encrypt all information the user submitted to the server.  
The program will then use DES and RSA to decrypt all information, print to a txt file.  

**Github offers static web hosting. So the program can only be demonstrated using a hosting platform such as VPS**


