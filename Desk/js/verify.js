    function checkfields(){
      
     
      var password = document.getElementById('password');
      var email = document.getElementById('email');
      var firstname = document.getElementById('first');
      var lastname = document.getElementById('last');
      var verifypass = document.getElementById('verify password');
      var username = document.getElementById('username');  


      check(password)  
      check(email)   
      check(firstname)  
      check(lastname)  
      check(verifypass)
      check(username)
     

     if(check(password) && check(email) &&  check(firstname) && check(lastname) && check(verifypass) && check(username)){
      return true;
     
     }
     else return false;

    }
    
    function verifyPassword(){
    var password = document.getElementById('password');
    var verifypass = document.getElementById('verify password');

      var bool = true;
      if(password.value != verifypass.value){
        verifypass.setAttribute('style', 'background-color: pink');
        password.setAttribute('style', 'background-color: pink');
        
        bool = false;
        
      }
      else {
          verifypass.setAttribute('style', 'background-color: white');
        password.setAttribute('style', 'background-color: white');
        bool = true;
        
      }

      return bool;
    }
    function verify(){

      var firstname = document.getElementById('first');
      var lastname = document.getElementById('last');
      verifyPassword()
      checkemail()
      checkfields()

      if(checkfields() && verifyPassword() && checkemail()){
        
         alert("Welcome " + firstname.value + " " + lastname.value)
      }
    }

    var testresults;
    function checkemail(){
      var str=document.getElementById("email")
      var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
      if (filter.test(str.value)){
        str.setAttribute('style', 'background-color: white ');
        testresults=true
      }
      else{
        str.setAttribute('style', 'background-color: pink');
        testresults=false

      }
      return (testresults)
    }

    function check(temp){
      if(temp.value == ""){
        temp.setAttribute('style', 'background-color: pink');
        return false;
      }
      else {
        temp.setAttribute('style', 'background-color: white');
        return true;
      }
    }