let getAllDeleteBtn = document.querySelectorAll('.deleteBtn');
let getAllModalDelete = document.querySelectorAll('.deleteModal');
let getAllNoDeleteLink = document.querySelectorAll('.deleteModal .noDelete');

getAllDeleteBtn.forEach(deleteBtn => {
    deleteBtn.addEventListener('click', function(e){
        e.preventDefault();
        getAllModalDelete.forEach(modal => {
            modal.classList.add('displayNone');
        });
        e.target.nextElementSibling.classList.remove('displayNone');
    });
});

getAllNoDeleteLink.forEach(noLink =>{
    noLink.addEventListener('click', function(e){
        e.preventDefault();
        e.target.parentElement.parentElement.classList.add('displayNone');
    })
});