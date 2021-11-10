"use strict";

/*
  JAVASCRIPT FOR INDEX.html
  Maria McKenzie
*/

//LOAD THE DOCUMENT
window.addEventListener("load", function() {
    let btn = document.querySelector("#lookup");

    console.log(btn);

    btn.addEventListener("click", function(e) {
        e.preventDefault();
        let res1 = "<ul>";
        let res2 = "";        
        let wrd = document.querySelector("#country").value;
        let txt = wrd.replace( /(<([^>]+)>)/ig, "");

        //capitalises the first letter of each word
        if (txt.length > 0) {
          txt = fixInput(txt);
        }

        fetch("world.php?country=" + txt)
            .then(response => {
                if (response.ok) {
                  //console.log(typeof response.text());//['name']);
                  return response.text();
                } else {
                  return Promise.reject("Error!");
                }
            })
            .then(data => {
                let result = document.querySelector("#result");
                result.innerHTML = data;
            })
            .catch(error => console.log(error))
    });
});

//function to capitalise the words - for search purposes
function fixInput(input) {
  let input_lst = input.split(" ");
  let input_with_caps = [];

  input_lst.forEach(element => {
    input_with_caps.push(element[0].toUpperCase() + element.slice(1, element.length));
  });

  return input_with_caps.join(" ");
}
