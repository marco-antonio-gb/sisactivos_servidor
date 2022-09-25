 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link rel="stylesheet" href="{{ asset('/css/contratos.css') }}" media="all" />
     <title>Render from VUE html</title>
     <style>
        
         * {
             box-sizing: border-box;
             -moz-box-sizing: border-box;
         }
 

     </style>
 </head>
 <body>
     <div class="page">
         {!!$datos!!}
     </div>
 </body>
 </html>
