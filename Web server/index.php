<html>
    <head>
        <title>Welcome</title>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="icon" href="cashfreecanteen.png">
<link rel="stylesheet" href="index.css">
<script src="float-panel.js"></script>
    </head>
    <body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card middle" id="myNavbar">

    <a href="#home" class="w3-bar-item w3-button"><img src="cashfreecanteen.png" style="width:300px" id="logo"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small" id="text">
      <a href="#about" class="w3-bar-item w3-button">ABOUT</a>

      <a href="#pricing" class="w3-bar-item w3-button"><i class="fa fa-usd"></i> PRICING</a>
      <a href="#contact" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i> CONTACT</a>

      <a href="login.php" class="w3-bar-item w3-button login"><i class="fa fa-user"></i> LOG IN</a>
      <a href="signup.html" class="w3-bar-item w3-button"><i class="fa fa-user-plus"></i> SIGN UP</a>

    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
  <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">ABOUT</a>

  <a href="#pricing" onclick="w3_close()" class="w3-bar-item w3-button">PRICING</a>
  <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button">CONTACT</a>
  <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">LOG IN</a>
  <a href="signup.html" onclick="w3_close()" class="w3-bar-item w3-button">SIGN UP</a>
</nav>

<!-- Header with full-height image --><div class='pushDownImage'></div>
<header class="bgimg-1 w3-display-container w3-grayscale-min" src="creditcard.jpeg" id="home">

  <div class="w3-display-left w3-text-white" style="padding:48px">
    <span class="w3-jumbo w3-hide-small">The future is here.</span><br>
    <span class="w3-xxlarge w3-hide-large w3-hide-medium">Start living smart</span><br>
    <span class="w3-large">Start living smart, start living contactless.</span>
    <p><a href="#about" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a></p>
  </div>
  
</header>

<!-- About Section -->
<div class="w3-container" style="padding:128px 16px" id="about">
  <h3 class="w3-center">WHAT WE DO</h3>

  <div class='container'>
      <div class='row'>

  <div class='w3-half module'>
  <p>Cashfreecanteen provides a contactless system that allows users to buy items, enter buildings and more using a single RFID chip. Users can either use a card, a tag, a sticker or even a bracelet. Cashfreecanteen allows your company to move away from cash, keys and other antiquated items, and start living contactless. </p><p>This system is ideal for schools, campuses and businesses seeking to improve their on-site technology and provide a better user experience.
  What makes us special is our passion for programming, and our consequent innovation and adaptability to our customers needs.</p>
  </div>
  <div class='w3-half module'>
  <img src='https://i.computer-bild.de/imgs/1/1/3/3/8/9/2/7/Apple-Card-1024x576-14c6da56065650a8.jpg' width='100%'>
  </div>
  </div>
  <br><br>
  <div class='row'>
      <div class='w3-half'>
  <div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="homescreenshot.png" style="width:100%">

</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="graphscreenshot.png" style="width:100%">

</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="profilescreenshot.png" style="width:100%">

</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div></div>
  <div class='w3-half'>
  <p>Our system consists both of hardware and software that interact together to provide optimal customer experience. </p>
    <p>Users are able to view their account balance, recent purchases and other information online.
 Administrators are also given live analytics of all purchases, allowing you to optimize your sales.</p>

</div>

  </div>
  </div>

  <br><br><br><br><br><br>
  <h3 class="w3-center">ABOUT THE COMPANY</h3>
  <p class="w3-center w3-large">Key features of our company</p>
  <div class="w3-row-padding w3-center" style="margin-top:64px">
    <div class="w3-quarter">
      <i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
      <p class="w3-large">Innovative</p>
      <p>Cashfreecanteen was founded in 2020, and uses cutting-edge technology to provide the best customer experience. </p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Passion</p>
      <p>At Cashfreecanteen, we all love what we do and hence are very willing to add new features according to our customer's needs</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-percent w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Value for money</p>
      <p>Due to our love for code and our work, we offer much lower prices than any other company.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-globe w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Eco-friendly</p>
      <p>20% of profits made by Cashfreecanteen are donated to the WWF charity.</p>
    </div>
  </div>
</div>

<!-- Team Section -->
<div class="container team" style="padding:128px 16px" id="team">
  <h3 class="w3-center">THE TEAM</h3>
  <p class="w3-center w3-large">The ones who run this company</p>

  <div class="row w3-grayscale" style="margin-top:64px">

    <div class="col  w3-center">
      <div class="w3-card">
        <img src="Alex3.jpg" alt="Alex" style="width:100%">
        <div class="w3-container">
            <br>
          <h3>Alex Oort</h3>
          <p class="w3-opacity">CEO & Founder</p>

          <p><a href="#contact"><button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button></a></p>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- Skills Section -->
<div class="w3-container w3-light-grey w3-padding-64">
  <div class="w3-row-padding">
    <div class="w3-col m6">
      <h3>Our Skills.</h3>
      <p>Our work is based around electronics, coding and innovation, and we try to find smart, cheap and efficient solutions for common problems.</p>

    </div>
    <div class="w3-col m6">
      <p class="w3-wide"><i class="fa fa-code w3-margin-right"></i>Coding</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-center" style="width:90%">90%</div>
      </div>
      <p class="w3-wide"><i class="fa fa-desktop w3-margin-right"></i>Web Design</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-center" style="width:80%">80%</div>
      </div>
      <p class="w3-wide"><i class="fa fa-line-chart w3-margin-right"></i>Innovation</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-center" style="width:85%">85%</div>
      </div>
    </div>
  </div>
</div>

<!-- Pricing Section -->
<div class="w3-container w3-center w3-dark-grey" style="padding:128px 16px" id="pricing">
  <h3>PRICING</h3>
  <p class="w3-large">Standard bundles that may fit your needs. </p><p> These are only default packages to give you an idea of our pricing. However, we are always happy to customize the system so that it exactly meets your needs.</p>
  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-third w3-section">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-black w3-xlarge w3-padding-32">Basic</li>
        <li class="w3-padding-16"><b>50</b> Users</li>
        <li class="w3-padding-16">Cashless payment system + online account</li>
        <li class="w3-padding-16">Keyless entry to one area</li>
        <li class="w3-padding-16"><b>Endless</b> Support</li>
        <li class="w3-padding-16">
          <h2 class="w3-wide">150€</h2>

        </li>
        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-black w3-padding-large">Sign Up</button>
        </li>
      </ul>
    </div>
    <div class="w3-third">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-red w3-xlarge w3-padding-48">Pro</li>
        <li class="w3-padding-16"><b>150</b> Users</li>
        <li class="w3-padding-16">Cashless payment system + online account</li>
        <li class="w3-padding-16">Keyless entry to 3 areas</li>
        <li class="w3-padding-16"><b>Endless</b> Support</li>
        <li class="w3-padding-16">
          <h2 class="w3-wide">250€</h2>

        </li>
        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-black w3-padding-large">Sign Up</button>
        </li>
      </ul>
    </div>
    <div class="w3-third w3-section">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-black w3-xlarge w3-padding-32">Premium</li>
        <li class="w3-padding-16"><b>400</b> Users</li>
        <li class="w3-padding-16">Cashless payment system + online account</li>
        <li class="w3-padding-16">Keyless access to 10 areas</li>
        <li class="w3-padding-16"><b>Endless</b> Support</li>
        <li class="w3-padding-16">
          <h2 class="w3-wide">500€</h2>

        </li>

        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-black w3-padding-large" type="submit" name="premium">Sign Up</button>
        </li>

      </ul>
    </div>
  </div>
  <br>

</div>

<!-- Contact Section -->
<div class="w3-container w3-light-grey" style="padding:128px 16px" id="contact">
  <h3 class="w3-center">CONTACT</h3>
  <p class="w3-center w3-large">Let's get in touch. Send us a message:</p>
  <div style="margin-top:48px">
    <p><i class="fa fa-map-marker fa-fw w3-xxlarge w3-margin-right"></i> Frankfurt, Germany</p>

    <p><i class="fa fa-envelope fa-fw w3-xxlarge w3-margin-right"> </i> Email: alex@cashfreecanteen.com</p>
    <br>
    <form action="/contact_email.php" method="post">
      <p><input class="w3-input w3-border" type="text" placeholder="Name" required name="Name"></p>
      <p><input class="w3-input w3-border" type="text" placeholder="Your Email address" required name="Email"></p>
      <p><input class="w3-input w3-border" type="text" placeholder="Subject" required name="Subject"></p>
      <p><input class="w3-input w3-border" type="text" placeholder="Message" required name="Message"></p>
      <p>
        <button class="w3-button w3-black" type="submit">
          <i class="fa fa-paper-plane"></i> SEND MESSAGE
        </button>
      </p>
    </form>
    

  </div>
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>

</footer>

<script>

// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {

  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    document.getElementById("text").style.padding = "10px 10px";
    document.getElementById("logo").style.width = "120px";
  } else {
    document.getElementById("text").style.padding = "40px 10px";
    document.getElementById("logo").style.width = "300px";
  }
}



// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}


// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}

var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}


</script>

</body>
</html>
