function runTimer(timerDuration)
{
	console.log("clicked");
	var timerDuration = timerDuration;
	var startTime = new Date();
	var endTime = new Date();
	endTime.setMinutes(startTime.getMinutes() + timerDuration);
	//sets the minutes of variable v to 30 minutes
	//check alerts
	var x = setInterval(function()
	{
		var now = new Date();
		var timeRemaining = endTime - now;
		var hours = Math.floor(( timeRemaining % (1000 * 60 * 60 * 24))/(1000 * 60 * 60));
		var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
		document.getElementById("timerDisplay").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
		if (timeRemaining < 0) {
			clearInterval(x);
			document.getElementById("timerDisplay").innerHTML = "CONGRATULATIONS! FINISHED LONG STUDY";
			alert("Gold trophy received.");
		}
	}, 1000);
}