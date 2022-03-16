let getAllSelectQuantity = document.querySelectorAll('tbody select');
let getAllProductTotal = document.querySelectorAll('tbody .productTotal');
let getCartTotal = document.querySelector('tfoot .footValue');
let totalCart;
let getHiddenTotalCart = document.getElementById('hiddenTotalCart');

let getAllDeleteBtn = document.querySelectorAll('tbody .deleteBtn');

getAllSelectQuantity.forEach(select =>{
    select.addEventListener('change', changeQuantity);
})

getAllDeleteBtn.forEach(deleteBtn => {
    deleteBtn.addEventListener('click', deleteProductFromCart);
})

// if(isset($_GET['action']) && $_GET['action'] == 'changeQuantity'){
//     if(isset($_GET['id']) && isset($_GET['quantity']) && $_GET['quantity']>0){

function changeQuantity(event){
    fetch('cart.php?action=changeQuantity&id=' + event.target.getAttribute('product_id') + '&quantity=' + event.target.value)
    .then(response => {return response.text();} )
    .then(text =>  
    {
        calculProductTotal(event.target);
        calculCartTotal();
        //changer le total
    }).catch(error => {console.log("Erreur :" + error.message) })
}

function calculProductTotal(select){
    let price = parseFloat(select.parentElement.previousElementSibling.children[0].textContent);
    let totalProduct = select.parentElement.nextElementSibling.children[0];
    totalProduct.textContent = price*select.value + '€';
}

function calculCartTotal(){
    totalCart = 0;
    getAllProductTotal.forEach(total => {
        totalCart += parseFloat(total.textContent);
    });
    getHiddenTotalCart.value = totalCart.toFixed(2);
    getCartTotal.textContent = totalCart.toFixed(2) + '€';
}

function deleteProductFromCart(event){
    event.preventDefault();
    fetch('cart.php?action=deleteProduct&id=' + event.target.getAttribute('product_id'))
    .then(response => { return response.text()})
    .then(result => {
        //Delete la ligne
        event.target.parentElement.parentElement.innerHTML = '';
        getAllProductTotal = document.querySelectorAll('tbody .productTotal');
        calculCartTotal();
        //Calcul total
        console.log(result);
    })
    .catch(error => {console.log("Erreur :" + error.message) })
}