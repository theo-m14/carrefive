let getSearchBar = document.getElementById('searchBar');
let getProductTab = document.querySelector('tbody');
let getAllTabColumn = document.querySelectorAll('thead th');
let shortProduct;
let getUrlGet = '';

getSearchBar.addEventListener('keyup', function(e){
    checkLogUser(e.target.value);
});

let getColumn;
let getTriangle;
let searchLetters = '';
let shortKey = 'product_id';
let orderBy = 'asc';

let getShortKey = {
    'ID#' : 'product_id',
    'NOM' : 'name',
    'PRIX' : 'price',
    'DLC' : 'dlc',
    'STOCK' :'stock',
}

getAllTabColumn.forEach(column =>{
    column.addEventListener('click',function(e){
        if(e.target.innerText !== 'ACTIONS'){
            if(e.target.innerText == '▼' || e.target.innerText == '▲'){
                getColumn = e.target.parentElement;
                getTriangle = e.target;
            }else{
                getColumn = e.target;
                getTriangle = e.target.lastChild;
            }
            getAllTabColumn.forEach(column => {
                column.classList.remove('active');
            });
            getColumn.classList.add('active');
            if(getTriangle.innerText == '▼'){
                getTriangle.innerText = '▲';
                orderBy = 'asc';
            }else{
                getTriangle.innerText = '▼';
                orderBy = 'desc';
            }
            arrayKey = getColumn.innerText.replace('▲','');
            arrayKey = arrayKey.replace('▼','');
            arrayKey = arrayKey.replace(' ','');
            shortKey = getShortKey[arrayKey];
            checkLogUser(getSearchBar.value);
        }
    })
});

function checkLogUser(targetValue){
    if(window.location.search == "?outOfStock"){
        getUrlGet = '&outOfStock';
    }else{
        getUrlGet = '';
    }
    fetch('?userConnected')
    .then(response => {return response.json();})
    .then(data => {
        searchProduct(targetValue,data['userConnected'],data['userAdmin']);
    }).catch(error => console.log("Erreur :" + error.message));
}

function searchProduct(value,userConnected,userAdmin){
    fetch('?search=' + value + getUrlGet)
    .then(response => {return response.json();})
    .then(product => {
        let searchProduct = '';
        let shortProduct = orderProduct(product);
        let dlc;
        for(element in shortProduct){
            (shortProduct[element]['dlc'] == null) ? dlc = '' : dlc = shortProduct[element]['dlc'];
            searchProduct += '<tr><td><p class="text-xs font-weight-bold mb-0 text-center">' + shortProduct[element]['product_id'] +'</td><td><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class="mb-0 text-sm">' + shortProduct[element]['name'] + '</h6></div></div></td><td><p class="text-xs font-weight-bold mb-0">'+ shortProduct[element]['price'] +'€</p></td><td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">' + dlc +'</span></td><td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">' + shortProduct[element]['product_stock'] +'</span></td><td class="align-middle text-center actionContainer"><a href="product.php?id=' + shortProduct[element]['product_id'] +'"class="text-secondary font-weight-bold text-xs text-primary mx-1"data-toggle="tooltip" data-original-title="Show product">Show</a>';
            if(userConnected == true){
                searchProduct += '<a href="editProduct.php?id=' + shortProduct[element]['product_id'] +'" class="text-secondary font-weight-bold text-xs mx-1" data-toggle="tooltip" data-original-title="Edit product">Edit</a>';
                if(userAdmin == true){
                    searchProduct += '<a href=""class="deleteBtn text-secondary font-weight-bold text-xs text-danger mx-1"data-toggle="tooltip" data-original-title="Delete product">Delete</a><div class="displayNone deleteModal"><p>Voulez vous vraiment supprimer le produit ' + shortProduct[element]['name'] + ' ?</p><div><a href="deleteProduct_post.php?id=' + shortProduct[element]['product_id'] +'">Oui</a><a href="" class="noDelete">Non</a></div></div>';
                }
                searchProduct += '</td></tr>';
                // </td></tr>';
            }else{
                searchProduct += '</td></tr>'
            }
        }
        getProductTab.innerHTML = searchProduct;
    }).catch(error => console.log("Erreur :" + error.message));
}

// 'ID#' : 'product_id',
//     'NOM' : 'name',
//     'PRIX' : 'price',
//     'DLC' : 'dlc'

function orderProduct(product){
    switch(shortKey){
        case 'product_id':
            shortProduct = product.sort(shortByIdAsc);
            break;
        case 'name':
            shortProduct = product.sort(shortByNameAsc);
            break;
        case 'price':
            shortProduct = product.sort(shortByPriceAsc);
            break;
        case 'dlc':
            shortProduct = product.sort(shortByDateAsc);
            break;
        case 'stock':
            shortProduct = product.sort(shortByStockAsc);
            break;
        }
    if(orderBy=='asc'){
        return shortProduct;
    }else{
        return shortProduct.reverse();
    }
}

function shortByIdAsc(a, b) {
    return a.product_id - b.product_id;
}

function shortByPriceAsc(a,b){
    return parseFloat(a.price) - parseFloat(b.price);
}

function shortByDateAsc(a,b){
    if(b.dlc == null && a.dlc == null){
        return 0;
    }else if(b.dlc == null){
        return -1;
    }else if(a.dlc == null){
        return 1;
    }else{
        return new Date(a.dlc) - new Date(b.dlc);
    }
}

function shortByNameAsc(a,b){
    return a.name.localeCompare(b.name);
}

function shortByStockAsc(a,b){
    return a.product_stock - b.product_stock;
}