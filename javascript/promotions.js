let promotions = [];

// changePromotionsView
function changePromotionsView () {
    const viewPromotions = document.getElementById('view-promotions')
    viewPromotions.innerHTML = '';
    promotions.forEach((promotion,index ) => { 
        const promotionDiv = document.createElement('div');
        promotionDiv.innerHTML = `

    <p><strong>Movie:</strong> ${promotion.movie} </p>
    <p><strong> Name:</strong> ${promotion.name}</p>
    <p><strong> Amount:</strong> ${promotion.amount}</p>
    `;
    viewPromotions.appendChild(promotionDiv);
});
}

// changeEditPromotions
function changeEditPromotions () {
const editPromotions = document.getElementById('edit-promotions-content')
    editPromotions.innerHTML = '';
    promotions.forEach((promotion,index ) => { 
        const promotionDiv = document.createElement('div');
        promotionDiv.innerHTML = `

    <p><strong>Movie:</strong> ${promotion.movie} </p>
    <p><strong> Content:</strong> ${promotion.name}</p>
    <p><strong> Amount:</strong> ${promotion.amount}</p>
    <button onclick ="removePromotion(${index})">Delete</button>
    `;
    editPromotions.appendChild(promotionDiv);
});
}


//addPromotion
function addPromotion(event) {
event.preventDefault();
const movie = document.getElementById('movie').value;
const name = document.getElementById('discount-name').value;
const amount = document.getElementById('discount-amount').value;
promotions.push({movie, name, amount});
changePromotionsView();
changeEditPromotions();
document.getElementById('promotion-form').reset();

}

//removePromotion
function removePromotion(index) {
promotions.splice(index, 1);
changePromotionsView();
changeEditPromotions();

}
// tab functions
function tabs() {
    document.querySelectorAll(".tabs-button").forEach(button => {
        button.addEventListener("click", () => {
            const sideBar = button.parentElement;
            const tabsContainer = sideBar.parentElement;
            const tabsNumber = button.getAttribute("tab-info");
            const tabToActivate = tabsContainer.querySelector(`.tabs-content[tab-info-data= "${tabsNumber}"]`);


            sideBar.querySelectorAll(".tabs-button").forEach(button => {
                button.classList.remove("tabs-button-active");

            });


            tabsContainer.querySelectorAll(".tabs-content").forEach(tab => {
                tab.classList.remove("tabs-content-active");

            });
            button.classList.add("tabs-button-active")
            tabToActivate.classList.add("tabs-content-active");
        });
    });
}


document.addEventListener("DOMContentLoaded", () => {
tabs();
document.getElementById('promotion-form').addEventListener('submit',addPromotion);

});