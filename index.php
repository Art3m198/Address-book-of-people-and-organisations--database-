<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html><html class=''>
<head>
<link href='https://fonts.googleapis.com/css?family=Oswald:700,300' rel='stylesheet' type='text/css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>
<style class="cp-pen-styles">* {
  box-sizing: border-box;
}

a.l1{ color: #202020; text-decoration: none; opacity: 0.9;}
a.l1:hover{color:#202020; opacity: 1.0; }

body {
  background-image: url("");
}

.title {
  text-align: center;
  font-family: 'Oswald';
  font-weight: 100;
  font-size: 3.75rem;
  letter-spacing: 5px;
  background: linear-gradient(rgba(255, 0, 0, 0), #444, rgba(255, 0, 0, 0));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 0;
}
@media screen and (min-width: 37.5em) {
  .title {
    font-size: 4.75rem;
  }
}

p {
  margin: 0 auto 2rem;
  text-align: center;
  font-family: 'oswald';
  font-size: 2.25rem;
  color: #444;
  font-weight: 100;
  width: 90%;
}
@media screen and (min-width: 37.5em) {
  p {
    height: 10%;
  }
}

.case-study-gallery {
  margin-top: 50px;
  width: 90%;
  margin: 50px auto;
  max-width: 1100px;
}

.case-study {
  position: relative;
  display: block;
  width: 90%;
  height: 250px;
  margin: 0 auto 2rem;
  background-size: cover;
  border-radius: 10px;
  box-shadow: 0px 25px 50px rgba(0, 0, 0, 0.5);
  overflow: hidden;
  transition: all .4s ease;
}
@media screen and (min-width: 37.5em) {
  .case-study {
    height: 300px;
  }
}
@media screen and (min-width: 45em) {
  .case-study {
    display: inline-block;
    width: 45%;
    margin-left: 25px;
  }
}

.case-study__img {
  width: 90%;
  display: block;
  margin-top: 50%;
  transform: translateY(50%);
  margin: 0 auto;
}

.case-study__overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  z-index: 10;
}
.case-study__overlay:after {
  content: '';
  width: 100%;
  border-radius: 10px;
  height: 100%;
  background-color: #202020;
  opacity: 0;
  position: absolute;
  top: 0;
  z-index: -10;
  left: 0;
  transition: all .3s ease;
}

.case-study__title {
  position: relative;
  top: 0px;
  margin-bottom: 2rem;
  margin-top: 4rem;
  font-size: 2.25rem;
  font-family: 'Oswald';
  font-weight: 100;
  color: white;
  text-align: center;
  letter-spacing: 5px;
  transition: all 0.3s cubic-bezier(0.3, 0, 0, 1.3);
}

.case-study__link {
  position: relative;
  display: block;
  width: 60%;
  top: 120px;
  padding: 10px;
  background-color: white;
  margin: 0 auto;
  font-family: 'Oswald';
  color: white;
  letter-spacing: 3px;
  text-decoration: none;
  text-align: center;
  border: 2px solid white;
  border-radius: 3px;
  font-size: 1.25em;
  transition: all 0.3s cubic-bezier(0.3, 0, 0, 1.3);
}
.case-study__link:hover {
  background-color: white;
  color: #202020;
}

.case-study:hover .case-study__title {
  top: 0;
}
.case-study:hover .case-study__link {
  top: 120;
}
.case-study:hover .case-study__overlay:after {
  opacity: .75;
}

.study1 {
  background-image: url("pic/1.jpg");
}

.study2 {
  background-image: url("pic/2.jpg");
}

.study3 {
  background-image: url("pic/3.jpg");
}

.study4 {
  background-image: url("pic/5.jpg");
}
.study5 {
  background-image: url("pic/6.jpg");
}
.study6 {
  background-image: url("pic/4.png");
}
</style></head><body>
<div class="case-study-gallery">
  <h1 class="title">Database</h1>
  <p>of people and organisations</p>
<div class="case-study study2">
  <div class="case-study__overlay">
    <a class="l1 case-study__link" href="data" target="_blank">Persons / organisations</a>
  </div>
</div>
 
 <div class="case-study study3">
  <div class="case-study__overlay">
    <a class="l1 case-study__link" href="https://telegram.org/" target="_blank">Feedback</a>
  </div>
</div>
<div class="case-study study6">
  <div class="case-study__overlay">
    <a class="l1 case-study__link" href="https://telegram.org/" target="_blank">We are in Telegram</a>
  </div>
</div>
<div class="case-study study4">
  <div class="case-study__overlay">
    <a class="l1 case-study__link" href="donate" target="_blank">Donate</a>
  </div>
</div>

<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body></html>