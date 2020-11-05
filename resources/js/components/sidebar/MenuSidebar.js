
let menuItems = [];
let submenuItems = [];

if (localStorage.getItem('tenant') != null ) {
  fetch(`/api/${localStorage.getItem('tenant')}/menu`).
    then(response => response.json()).
    then((data) =>
      data.forEach(element => {
        if (element.descripcion != 'App' && element.descripcion != 'Administrativo') {
          menuItems.push({ item: element.descripcion, icon: element.icon })
          submenuItems.push({ item: element.descripcion, listItems: element.submenus })
        }
      }))  
}

export default {
  menuItems,
  submenuItems
}
