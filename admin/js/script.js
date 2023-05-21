function neueZutat() {

    var block = document.querySelector(".zutatenliste .zutatenblock");
    var neuer_block = block.cloneNode(true);
    document.querySelector(".zutatenliste").appendChild(neuer_block);

    neuer_block.querySelector("select").value = "";
    neuer_block.querySelector('input[name="menge[]"]').value = "";
    neuer_block.querySelector('input[name="einheit[]"]').value = "";

    var rand = (new Date()).getTime();
    neuer_block.querySelector('label[for="zutaten_id"]').setAttribute("for", "zutaten_id_"+rand);
    neuer_block.querySelector('select[id="zutaten_id"]').setAttribute("id", "zutaten_id_"+rand);

}