let getSearchBar = document.getElementById('searchBar');
let getProductTable = document.querySelector('.product_table');

let getAddToCartBtn = document.querySelectorAll('.addToCartBtn');
let productId;
let getCartBtn = document.querySelector('#cartBtn span');
let productInCart = 0;
let quantity;

if(getCartBtn.textContent.length >= 10){
    productInCart = parseInt(getCartBtn.textContent.slice(8,getCartBtn.textContent.length));
}

getSearchBar.addEventListener('keyup', function(e){
    searchProduct(e.target.value);
});

getAddToCartBtn.forEach(addToCartBtn => {
    addToCartBtn.addEventListener('click', addToCart);
})


function searchProduct(value){
    fetch('?search=' + value + '&quantity')
    .then(response => {return response.json();})
    .then(product => {
        let searchProduct = '';
        let img;
        for(element in product){
            (product[element]['image'] == null) ? img = 'nophoto.png' : img=product[element]['image'];
                    searchProduct += '<div class="product_container"><img src="assets/img/product_images/' + img +'"><h5>' + product[element]['name'] +'</h5><p>Prix : ' + product[element]['price'] + '€<a href="product.php?id=' + product[element]['product_id'] +'">Voir</a><a href="" class="addToCartBtn" id="' +  product[element]['product_id'] + '">Ajouter au Panier</a></div>';
        }
        getProductTable.innerHTML = searchProduct;
    }).catch(error => console.log("Erreur :" + error.message));
}

function addToCart(event){
    event.preventDefault();
    quantity = event.target.previousSibling.value;
    console.log(quantity);
    productId = event.target.id;
    fetch('?addToCart=' + productId + '&quantity=' + quantity)
    .then(response => {return response.text();})
    .then(data =>{
    productInCart++;
    event.target.parentElement.innerHTML = '<p>Ajouté au panier !</p>';
    getCartBtn.innerText = 'Panier (' + productInCart +')';
   }).catch(error => {
       console.log("Erreur :" + error.message);
       event.target.parentElement.innerHTML = '<p>Une erreur est survenue</p>';
   })
}