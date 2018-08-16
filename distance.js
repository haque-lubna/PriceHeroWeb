<script>
 var mysql = require('mysql');
          var con = createConnection({
                   host : 'localhost',
                   user : 'root',
                   password: '',
                   database : 'authentication'
          });
          con.connect(function(err){
            if(err){
              console.log('error to connect database');
            }

          });
          </script>