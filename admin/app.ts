
window.addEventListener('load', function () {
    document.querySelectorAll('.cep input').forEach(item => {
        item.addEventListener('keyup', e => {
            if(e.target.value.length > 5) {
                e.target.value = e.target.value.replace(/([\d]{5})-?([\d]{3})?/gi, '$1-$2')            
            }
        })
    })
})