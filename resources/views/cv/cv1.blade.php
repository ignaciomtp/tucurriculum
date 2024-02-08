<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<style type="text/css">
.nametitle {
  font-size: 35px;
  color: #AA9739;
  font-family: 'Maven';
  line-height: 35px;
}

.jobtitle {
  font-size: 25px;
  
}

.address {
  font-size: 14px;
  color: #AA9739;
  
}

.section {
  font-size: 20px;
  color: #AA9739;
  
  border-bottom: 1px solid #AA9739;
}

.col-container {
  display: flex;
  justify-content: space-between;
}

.h-block {
  width: 40%;
}

.block-20 {
  width: 20%;
}

.block-30 {
  width: 30%;
}

.clrl {
  clear: left;
}

.clrr {
  clear: right;
}

.f-right {
  float: right;
}

.borde-r {
  border: 1px solid red;
}

.borde-v {
  border: 1px solid green;
}

.borde-a {
  border: 1px solid blue;
}

</style>


    <title>Hello, world!</title>
  </head>
  <body>
    <div class="col-container">

      <div class="block-20 f-right clrr">
        <div class="address ">
          {{ $user->address }}, <br>
          {{ $user->zip }} {{ $user->city }} <br>
          {{ $user->email }} <br>
          {{ $user->phone }}
        </div>
      </div>


      <div class="clr ">
        <div class="nametitle " >
          {{ $user->name }} {{ $user->surname }}
        </div>
        <div class="jobtitle">
          Food Service Manager
        </div>
      </div>

    </div>

    <div class="mv-4">
     {{ $user->job }}
    </div>

    <div class="section">
      Profesional Experience
    </div>

    <div class="sectioncontent">
      Assistant Manager, Burger World, Orlando, FL – January 2010 – present

      <ul>
        <li>Create a weekly schedule based on hourly sales and employee availability</li>
        <li>Prepare burgers, fries, nuggets and onion rings using restaurant equipment</li>
        <li>Implement and monitor safety guidelines to promote employee safety</li>
        <li>Transform frustrated customers into satisfied guests by following company recommendations</li>

      </ul>
      
    </div>




  </body>
</html>