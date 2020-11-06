
let menuItems = [];
let submenuItems = [];

if (localStorage.getItem('tenant') != null) {


  fetch(`/api/${localStorage.getItem('tenant')}/menu`).then(function (response) {
    if (response.ok) {
      response.json().then((data) => {
        data.forEach(element => {
          if (element.descripcion != 'App' && element.descripcion != 'Administrativo') {
            menuItems.push({ item: element.descripcion, icon: element.icon })
            submenuItems.push({ item: element.descripcion, listItems: element.submenus })
          }
        })
      })
    } else {
      console.log('Respuesta de red OK pero respuesta HTTP no OK');
    }
  })
    .catch(function (error) {
      console.log('Hubo un problema con la petición Fetch:' + error.message);
    });
}

export default {
  menuItems,
  submenuItems
}
