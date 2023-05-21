// list alle Rezepte mit AJAX request

$.ajax({
  url: 'http://localhost/Speisekarte/speisekarte/api/v1/rezepte',
  type: 'GET',
  success: function(data){
    
    if (data.status != 1) return;

    const rezepteContainer = document.getElementById('rezepte');
    data.result.forEach(rezept => {

      const containerDiv = document.createElement('div');

      // dynamisch ein element machen 
      const textDiv = document.createElement('p');
      textDiv.classList.add('subtitle-menu');
      // text in element einfügen 
      textDiv.innerHTML = rezept.titel;
      // element and dem parent element hängen 
      containerDiv.appendChild(textDiv);

        // dynamisch ein img machen 
        const img = document.createElement('img');
        img.classList.add('imgmenu');
        img.src = rezept.img_url;
        containerDiv.appendChild(img);

        const preisDiv = document.createElement('div');
        preisDiv.classList.add('preis');
        preisDiv.innerHTML = rezept.preis;

        containerDiv.appendChild(preisDiv);
    
        rezepteContainer.appendChild(containerDiv);
    })
  }
});
