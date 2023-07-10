$(document).ready(function(){
/*     fetch('view.json')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error(error));

for (i=0; i<=10; i++){
    console.log(i); 
    $("body").append("<p>" + i + "</p>");
}
 */
fetch('js/view.json')
  .then(response => response.json())
  .then(data => {
    for (let i = 0; i < data.length; i++) {
      $("body").append("<p>" + data[i].name +  "</p>");
    }
  })
  .catch(error => console.error(error));

})