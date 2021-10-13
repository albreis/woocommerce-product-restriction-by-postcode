
class ProductRestrictionByPostcode {
  public popup = document.querySelector('.product-restriction-by-postcode')
  public input = this.popup.querySelector('input')  
  public button = this.popup.querySelector('button')
  constructor() {
    /**
     * Carrega o VueJS 
     */
    let vue = document.createElement('script')
    vue.src = 'https://unpkg.com/vue'
    document.body.appendChild(vue)

    /**
     * Carrega o Axios
     */
    let axios = document.createElement('script')
    axios.src = 'https://unpkg.com/axios'
    document.body.appendChild(axios)
    if(document.querySelector('#popupcep')) {
      document.querySelector('#popupcep').addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()
        this.popup.style.display = 'flex'
      })
    }
  }

  /**
   * Salva o CEP na session
   */
  save_postcode(postcode) {
    axios.post(window.ajaxurl, { postcode }, {params: {action: 'save_postcode'}}).then(res => {
      console.log(res.data)
      this.popup.style.display = 'none'
    })
  }
}

window.addEventListener('load', function(){
  var app = new ProductRestrictionByPostcode
  app.input.addEventListener('keyup', e => {
    let postcode = app.input.value
    if(postcode.length == 8) {
      app.button.style.display = 'block'
    }
  })
  
  app.button.addEventListener('click', () => {
    let postcode = app.input.value
    app.save_postcode(postcode)
  })
})