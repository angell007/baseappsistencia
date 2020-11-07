
import axios from 'axios';

export async function menus() {
  if (localStorage.getItem('tenant') != null) {
    const response = await axios.get(`/api/${localStorage.getItem('tenant')}/menu`);
    const data = await response.data;
    return data;
  }
}
