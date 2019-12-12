<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>
<div class="demo"></div>	
<div id="test"></div>	
</h1>
<script type="text/javascript">
// setInterval(function(){	
// let now=new Date();
//  // now=new Date().getMinutes();
//  let seconds= now.getSeconds();
// let minutes=now.getMinutes();
// var fiveMin = 60 * 5; //five minutes is 300 seconds!

//  console.log(minutes);
//  console.log(seconds);
//  // document.getElementsByClassName('demo').text=seconds;
//  // document.getElementById('test').innerHTML = seconds;

 
// // console.log(now);
// },1000);

//     var d = new Date(); //get current time
// setInterval(function () {
//     var seconds = d.getMinutes() * 60 + d.getSeconds(); //convet current mm:ss to seconds for easier caculation, we don't care hours.
//     var fiveMin = 60 * 5; //five minutes is 300 seconds!
//     var timeleft = fiveMin - seconds % fiveMin; // let's say now is 01:30, then current seconds is 60+30 = 90. And 90%300 = 90, finally 300-90 = 210. That's the time left!
//     var result = parseInt(timeleft / 60) + ':' + timeleft % 60; //formart seconds back into mm:ss 
//     document.getElementById('test').innerHTML = result;

// }, 500) //calling it every 0.5 second to do a count down


var seconds=200;
var countDiv=document.getElementById('test')
countDown =setInterval(function(){
secondpass();
},1000
);

function secondpass()
{

	var min= Math.floor(seconds/60);
	var rsec=seconds%60;
	countDiv.innerHTML=min+'minute'+rsec+'seconds';
	console.log(rsec);
	if(seconds>0)
	{
		seconds=seconds-1;
	}

}
</script>
</body>
</html>