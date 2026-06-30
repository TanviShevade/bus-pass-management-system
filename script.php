<?php 
// by default, error messages are empty 
$valid=$fnameErr=$lnameErr=$emailErr=$passErr=$cpassErr=''; 
// by default,set input values are empty 
$set_firstName=$set_lastName=$set_email='';  
extract($_POST); 
if(isset($_POST['register'])) 
{ 
//input fields are Validated with regular expression 
$validName="/^[a-zA-Z ]*$/"; 
$validEmail="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/"; 
$uppercasePassword = "/(?=.*?[A-Z])/"; 
$lowercasePassword = "/(?=.*?[a-z])/"; 
$digitPassword = "/(?=.*?[0-9])/"; 
$spacesPassword = "/^$|\s+/"; 
$symbolPassword = "/(?=.*?[#?!@$%^&*-])/"; 
$minEightPassword = "/.{8,}/"; 
// First Name Validation 
if(empty($first_name)){ 
$fnameErr="First Name is Required";  
} 
else if (!preg_match($validName,$first_name)) { 
$fnameErr="Digits are not allowed"; 
}else{ 
$fnameErr=true; 
} 
// Last Name Validation 
if(empty($last_name)){ 
$lnameErr="Last Name is Required";  
} 
else if (!preg_match($validName,$last_name)) { 
$lnameErr="Digits are not allowed"; 
} 
else{ 
$lnameErr=true; 
} 
//Email Address Validation 
if(empty($email)){ 
$emailErr="Email is Required";  
} 
else if (!preg_match($validEmail,$email)) { 
$emailErr="Invalid Email Address"; 
} 
else{ 
$emailErr=true; 
} 
// password validation  
if(empty($password)){ 
$passErr="Password is Required";  
}  
elseif (!preg_match($uppercasePassword,$password) 
|| !preg_match($lowercasePassword,$password) || !preg_match($digitPassword,$password) 
|| !preg_match($symbolPassword,$password) || !preg_match($minEightPassword,$password) || 
preg_match($spacesPassword,$password)) { 
$passErr="Password must be at least one uppercase letter, lowercase letter, digit, a special 
character with no spaces and minimum 8 length"; 
} 
else{ 
$passErr=true; 
} 
// form validation for confirm password 
if($cpassword!=$password){ 
$cpassErr="Confirm Password doest Matched"; 
} 
else{ 
$cpassErr=true; 
} 
// check all fields are valid or not 
if($fnameErr==1 && $lnameErr==1 && $emailErr==1 && $passErr==1 && $cpassErr==1) 
{ 
$valid="All fields are validated successfully"; 
//legal input values 
$firstName= legal_input($first_name); 
$lastName= legal_input($first_name); 
$email= legal_input($email); 
$password= legal_input($password); 
// here you can write  Sql Query to insert user data into database table 
}else{ 
// set input values is empty until input field is invalid 
$set_firstName=$first_name; 
$set_lastName= $last_name; 
$set_email= $email; 
} 
} 
// convert illegal input value to ligal value formate 
function legal_input($value) { 
$value = trim($value); 
$value = stripslashes($value); 
$value = htmlspecialchars($value); 
return $value; 
} 
?>