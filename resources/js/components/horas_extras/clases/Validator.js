/** Clase base para la validación de recargos nocturnos  y extras*/
export class Validator {
  /**
   * @param {Object} horaDeEntrada Recibe la hora de entrada del funcionario en objeto momentJS
   * @param {Object} horaDeSalida  Recibe la hora de salida del funcionario en objeto momentJS
   * @param {Sring} horaInicioNoche Recibe la hora de inicio noche, que para la app es a partir de las 21:00pm
   * @param {String} horaFinNoche  Recibe la hora de inicio noche, que para la app es a partir de las 06:00am
   */
  constructor(
    horaDeEntrada = {},
    horaDeSalida = {},
    horaInicioNoche = null,
    horaFinNoche = null
  ) {
    this.horaDeEntrada = horaDeEntrada
    this.horaDeSalida = horaDeSalida
    this.horaInicioNoche = horaInicioNoche
    this.horaFinNoche = horaFinNoche
    this.entrada = this.horaDeEntrada.clone()
    this.salida = this.horaDeSalida.clone()
  }

  /** Retorna la diferencia en minutos de una hora con respecto a otra
   * @param {String}
   * @param {String}
   * @return {Number}
   */
  diferenciaInMinutos(horaA, horaB) {
    return moment
      .duration(moment(horaA, 'HH:mm:ss').diff(moment(horaB, 'HH:mm:ss')))
      .as('minutes')
  }

  /** Retorna la diferencia en horas de una hora con respecto a otra
   * @param {String}
   * @param {String}
   * @return {Number}
   */
  diferenciaInHoras(horaUno, horaDos) {
    return moment
      .duration(moment(horaUno, 'HH:mm:ss').diff(moment(horaDos, 'HH:mm:ss')))
      .asHours()
  }

  /** Retorna la hora de inicio noche en formato hora: minutos: segundos
   * @return  {String}
   */
  inicioNocheToMomentString() {
    return moment.utc(this.horaInicioNoche, 'HH:mm:ss').format('HH:mm:ss')
  }

  /** Retorna la hora de fin noche en formato hora: minutos: segundos
   * @return {String}
   */
  finNocheToMomentString() {
    return moment.utc(this.horaFinNoche, 'HH:mm:ss').format('HH:mm:ss')
  }

  /** Retorna la entrada del funcionario en formato hora: minutos: segundos
   * @return {String}
   */
  entradaToMomentString() {
    return this.entrada.format('HH:mm:ss')
  }

  /** Retorna la salida del funcionario en formato hora: minutos: segundos
   * @return {String}
   */
  salidaToMomentString() {
    return this.salida.format('HH:mm:ss')
  }
}
