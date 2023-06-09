let addIngredientButton = document.querySelector("#addIngredientButton");
let ingredientsContainer = document.querySelector("#ingredients");
let number = 0;
function getAllIngredients() {
    return new Promise((resolve, reject) => {

        let xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost:8080/index.php/ingredient?action=getAll", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let jsonResponse = JSON.parse(xhr.responseText);
                resolve(jsonResponse);
            } else {
                reject("error");
            }
        }
        xhr.send();
    });

}
addIngredientButton.addEventListener("click", function () {
    //number++;
    getAllIngredients()
        .then(function(response){
            console.log(response)
            let newSelect = document.createElement("select");
            newSelect.name = "ingredient" + number;
            for (let i = 0; i < response.length; i++) {
                let newOption = document.createElement("option");
                newOption.value = response[i].id;
                newOption.innerHTML = response[i].name;
                newSelect.appendChild(newOption);
            }
            ingredientsContainer.appendChild(newSelect);
        })

        .catch(function(error) {
            console.log(error);
        })
})