export class Peticion {
  constructor(datos) {
    this.datos = datos
  }

  actualizar(url) {
    return axios.put(url, this.datos)
  }
}
