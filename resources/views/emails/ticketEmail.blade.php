<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="mobile-web-app-capable" content="yes" />
        <title></title>

        <!-- Fonts -->
        <style>
          .text-title__card{
            font-size: 3rem;
            text-align: center;
            font-weight: bold;
            width: 100%;
          }
          .overlay {
            background-color: #FFFFFF;
          }
          .shadow {
            background-color: red;
            width: 50.2%; margin:auto;
            border-radius:15px;
          }
          .shadow .overlay {
            bottom: 4px;
            position: relative;
            right: 4px;
          }
          .text-title__card span img {
            margin-top: -25px;
          }
          .ticket__number{
            margin-bottom: 0px; 
            font-size:5rem; 
            color:#05A952;
            line-height: 1.4;
            font-weight: bold;
            text-align: center;
          }
          .ticket__info{
            display:flex;
            flex-wrap:wrap;
          }
          .ticket__info--item {
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            margin: 10px 0px;
          }
        
          .ticket__info--item-text{
            width:60%;
            margin-left: 2px;
            font-size: 0.9rem;
          }
          .mt-2r{
            margin-top: 1rem;
          }
          .text-subtitle{
            font-size:0.9rem;
          }
          
        </style>
    </head>
    <!-- <body class="antialiased"> -->
    <body class="antialiased mobile touch">

        <div  style="height: 100vh; width:100%; background:#05A952;padding-top:50px">
          <div class="shadow">

            <div class="overlay" style="width: 100%; margin:auto; background:white; ; border-radius:15px; padding:20px; box-shadow: 0px 5px 10px 1px #023319d9">
  
              <div>
                <div class="text-title__card" style="margin-bottom:0px">
                    Tu ticket 🎉
                </div>
                <div class="view-ticket">
                  <div class="number_section" style="border-bottom: 1px solid black; border-top: 1px solid black">
                    <div class="text-bold text-center ticket__number">
                    0002
                    </div>
                  </div>
                  <div class="mt-2 ticket__info">
                    <div class="ticket__info--item">
                      <!-- <n-icon size="30px" :component="Building24Regular" />  -->
                      <div class="ticket__info--item-text"></div>
                    </div>
                    <div class="ticket__info--item">
                      <!-- <n-icon size="30px" :component="Person20Filled" />  -->
                      <div class="ticket__info--item-text">
                        
                      </div>
                    </div>
                    <div class="ticket__info--item">
                      <!-- <n-icon size="30px" :component="CalendarLtr24Regular" />  -->
                      <div class="ticket__info--item-text">
                        
                      </div>
                    </div>
                    <div class="ticket__info--item">
                      <!-- <n-icon size="30px" :component="PersonCall24Regular" />  -->
                      <div class="ticket__info--item-text"></div>
                    </div>
                  </div>
                  <div>
                    <div class="text-center mt-2 text-subtitle">
                      Puedes revisar tu posición en la cola en el siguiente link, o escaneando el codigo QR
                    </div>
                    <div class="qr__container mt-2r">
                      <a class="mt-2r link_ticket" :href="#" target="_blank">
                        https://example.com/view/1/2
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </body>
</html>