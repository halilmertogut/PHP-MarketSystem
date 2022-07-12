function addShoppingCart(id){
    const qty = $('#qty').val();
    $.ajax({
        url: './assets/ajax/add-to-cart.php',
        type: 'POST',
        data: {id:id , qty:qty},
        success: function(data){
            if(data == 'ok'){
                alert('Product successfully added to cart');
                location.reload();
            }else{
                alert('You exceed stock quantity');
            }
        }
    });
}

function deleteCart(id){
    $.ajax({
        url: './assets/ajax/delete-cart.php',
        type: 'POST',
        data: {id:id},
        success: function(data){
            if(data == 'ok'){
                alert('The product has been removed from the cart');
                location.reload();
            }else{
                alert('Something went wrong !');
            }
        }
    });
}

function InCreaseCart(id){
    $.ajax({
        url: './assets/ajax/increase-cart.php',
        type: 'POST',
        data: {id:id},
        success: function(data){
            if(data == 'ok'){
                alert('Item Successfully increased by 1');
                location.reload();
            }else{
                alert('You exceed stock quantity');
            }
        }
    });
}

function DeCreaseCart(id){
    $.ajax({
        url: './assets/ajax/decrease-cart.php',
        type: 'POST',
        data: {id:id},
        success: function(data){
            if(data == 'ok'){
                alert('Item Successfully reduced by 1');
                location.reload();
            }else{
                alert('Something went wrong !');
            }
        }
    });
}

function CompleteShopping(totalPrice){
    $.ajax({
        url: './assets/ajax/complete-shopping.php',
        type: 'POST',
        data: {totalPrice:totalPrice},
        success: function(data){
            if(data == 'ok'){
                alert('Your Purchase Has Been Successfully Completed');
                location.reload();
            }else{
                alert('Something went wrong !');
            }
        }
    });
}