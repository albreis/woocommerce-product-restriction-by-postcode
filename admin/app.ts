
window.addEventListener('load', function () {
    document.querySelectorAll('[data-name="de"] input').forEach(item => {
        item.addEventListener('keyup', e => {
            if(e.target.value.length > 5) {
                e.target.value = e.target.value.replace(/([\d]{5})-?([\d]{3})?/gi, '$1-$2')            
            }
        })
    })
    document.querySelectorAll('[data-name="ate"] input').forEach(item => {
        item.addEventListener('keyup', e => {
            if(e.target.value.length > 5) {
                e.target.value = e.target.value.replace(/([\d]{5})-?([\d]{3})?/gi, '$1-$2')            
            }
        })
    })
    document.querySelectorAll('[data-name="cep"] input').forEach(item => {
        item.addEventListener('keyup', e => {
            if(e.target.value.length > 5) {
                e.target.value = e.target.value.replace(/([\d]{5})-?([\d]{3})?/gi, '$1-$2')            
            }
        })
    })
})