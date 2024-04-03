function permisosglobales() {
  const tipousuario = document.getElementById("tipousuario").value;

  const permiso = true; // Cambia a false para ocultar los elementos

  const lista = document.getElementById("miLista"); // Obtén la lista ul
  const elementosLi = lista.getElementsByTagName("li"); // Obtén todos los elementos li dentro de la lista

  // Itera a través de los elementos li y muestra u oculta según el valor de la variable permiso
  if (tipousuario == 3) {
    for (let i = 0; i < elementosLi.length; i++) {
      const idElemento = elementosLi[i].id;
      if (idElemento != "licatalogos") {
        elementosLi[i].style.display = "list-item"; // Mostrar el elemento
      } else {
        elementosLi[i].style.display = "none"; // Ocultar el elemento
      }
      console.log(idElemento);
    }
    
  }

  console.log(tipousuario);
  
}

permisosglobales();
