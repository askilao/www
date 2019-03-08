function printCourses(courses) {
  //document.getElementById("studies").innerHTML = courses;
  var html = "";
  for (x in courses) {
    html += `<div><h3>${courses[x].name}</h3><b>${courses[x].studyLevelName}</b><b>, ${courses[x].locationspretty}</b>`;
    document.getElementById("studies").innerHTML = html
    //console.log(courses.length);
  }

}


var oReq = new XMLHttpRequest();
var courses;
oReq.onload = function (res) {
  courses = JSON.parse(res.target.responseText);
  printCourses(courses);
};

oReq.open("GET", "getJson.php?p="+encodeURIComponent("https://www.ntnu.no/web/studier/alle?p_p_id=studyprogrammelistportlet_WAR_studyprogrammelistportlet&p_p_lifecycle=2&p_p_state=normal&p_p_mode=view&p_p_resource_id=allStudies&p_p_cacheability=cacheLevelPage&p_p_col_id=column-1&p_p_col_count=1"));
oReq.send();

var locations = [];
$("[type=checkbox]").on('change', function() { // always use change event 
    
    var idx = locations.indexOf(this.value);
    if (!this.checked) {
      locations.splice(idx, 1);
    }
    if (this.checked) {
      locations.push(this.value);
    }
    if (locations.length == 0) {
      printCourses(courses);
    } else {
      var tmpCourse;
      tmpCourse = courses.filter(filtered);

      printCourses(tmpCourse);
    }
});

function filtered(value) {
  for (x in locations) {
    if (value.locationspretty == locations[x]) {
      console.log(value.locationspretty);
      return true;
    }
  }
}
