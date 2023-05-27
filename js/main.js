
// list alle Kategorien mit AJAX request

$.ajax({
  url: 'http://localhost/Speisekarte/speisekarte/api/v1/kategorien/list',
  type: 'GET',
  success: function(res){
    
    if (res.status != 1) return;

    const kategorienContainer = document.getElementById('kategorien');

    res.result.forEach(data => {

      kategorieProdukteAnlegen(data);
      
      const containerLi = document.createElement('li');
      containerLi.classList.add('promo-item');

      kategorienContainer.appendChild(containerLi);

      const cardDiv = document.createElement('div');
      cardDiv.classList.add('promo-card');

      containerLi.appendChild(cardDiv);

      const iconDiv = document.createElement('div');
      iconDiv.classList.add('card-icon');

      if (data.img_url) {
        const img = document.createElement('img');
        img.src = data.img_url;
        iconDiv.appendChild(img);
      }

      const link = document.createElement('a');
      link.href = '#' + data.name;

      cardDiv.appendChild(iconDiv);
      cardDiv.appendChild(link);

      const h3 = document.createElement('h3');
      h3.classList.add('card-title');
      h3.classList.add('h3');
      h3.innerHTML = data.name;
      
      link.appendChild(h3);
    
    })
  }
});


function kategorieProdukteAnlegen(kategorie) {

  $.ajax({
    url: `http://localhost/Speisekarte/speisekarte/api/v1/kategorien/${kategorie.id}/produkte`,
    type: 'GET',
    success: function(res){
      
      if (res.status != 1) return;
  
      if (res.result.length == 0) return;
  
      const produkteContainer = document.getElementById('produkte');

      const kategorieProdukteContainer = document.createElement('div');
      kategorieProdukteContainer.classList.add('produkte-container');
      kategorieProdukteContainer.id = kategorie.name;
      
      const kategorieName = document.createElement('h1');
      kategorieName.innerHTML = kategorie.name;
  
      produkteContainer.appendChild(kategorieName);
      produkteContainer.appendChild(kategorieProdukteContainer);

      res.result.forEach(data => {
  
        const containerDiv = document.createElement('div');
  
        // dynamisch ein element machen 
        const textDiv = document.createElement('p');
        textDiv.classList.add('subtitle-menu');
        // text in element einfügen 
        textDiv.innerHTML = data.titel;
        // element and dem parent element hängen 
        containerDiv.appendChild(textDiv);
  
          // dynamisch ein img machen 
          const img = document.createElement('img');
          img.classList.add('imgmenu');
          img.src = data.img_url;
          containerDiv.appendChild(img);
  
          const preisDiv = document.createElement('div');
          preisDiv.classList.add('preis');
          preisDiv.innerHTML = data.preis;
  
          containerDiv.appendChild(preisDiv);
      
          kategorieProdukteContainer.appendChild(containerDiv);
      })
    }
  });

}
