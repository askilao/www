var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
	if (xhr.readyState == XMLHttpRequest.DONE) {
		
		courses = JSON.parse(xhr.responseText);
     	courses.forEach(course=&gt; {
        	
      });
		//document.getElementById("studies").innerHTML = courses;
	}
}

xhr.open('GET', 'getJson.php', true);
xhr.send(null);

/*
&lt; stands for the less-than sign ( < )
&gt; stands for the greater-than sign ( > )
&le; stands for the less-than or equals sign ( ≤ )
&ge; stands for the greater-than or equals sign ( ≥ )
*/
