<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Meow</title>
<style>
body{
margin:0;
height:100vh;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
background:#111;
color:#fff;
font-family:Arial;
}

.label{
margin-bottom:12px;
font-size:20px;
}

video{
width:320px;
max-width:90vw;
cursor:pointer;
border-radius:10px;
transition:transform 0.2s ease;
}

video:hover{
transform:scale(1.08);
}

video.clicked{
transform:scale(0.92);
}

.counter{
font-size:18px;
opacity:0.8;
}
</style>
</head>
<body>

<div class="label">click = meow</div>
<br>
<video id="meowVideo" src="./video.php"></video>

<br><br>
<div class="counter">meows: 0</div>

<script>
const video=document.getElementById("meowVideo");
const counter=document.querySelector(".counter");
let count=0;

video.addEventListener("click",()=>{
video.classList.add("clicked");
setTimeout(()=>video.classList.remove("clicked"),150);

video.currentTime=0;
video.play();

count++;
counter.textContent="meows: "+count;
});
</script>

</body>
</html>