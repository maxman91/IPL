function hidebowling(){
		var a = document.getElementById("bowling_list");
    	var b = document.getElementById("hidebowling");
    	var c = document.getElementById("showbowling");
    	
    		a.style.display = "none"; 
    		b.style.display = "none"; 
    		c.style.display = "inline-block"; 
    		
    		

		}

function showbowling(){
		var a = document.getElementById("bowling_list");
		var b = document.getElementById("hidebowling");
    	var c = document.getElementById("showbowling");
    	
    	
    		a.style.display = ""; 
    		b.style.display = "inline-block"; 
    		c.style.display = "none"; 
    		
    		

		}



function hidebatting(){
		var a = document.getElementById("batting_list");
    	var b = document.getElementById("hidebatting");
    	var c = document.getElementById("showbatting");
    	
    		a.style.display = "none"; 
    		b.style.display = "none"; 
    		c.style.display = "inline-block"; 
    		
    		

		}

function showbatting(){
		var a = document.getElementById("batting_list");
		var b = document.getElementById("hidebatting");
    	var c = document.getElementById("showbatting");
    	
    	
    		a.style.display = ""; 
    		b.style.display = "inline-block"; 
    		c.style.display = "none"; 
    		
    		

		}


function load(){
	var a = document.getElementById("batting_list");
	var b = document.getElementById("hidebatting");
    var c = document.getElementById("showbatting");
    var d = document.getElementById("bowling_list");
    var e = document.getElementById("hidebowling");
    var f = document.getElementById("showbowling");

    a.style.display = "none"; 
    b.style.display = "none"; 
    c.style.display = "inline-block"; 
    d.style.display = "none"; 
    e.style.display = "none"; 
    f.style.display = "inline-block"; 

}