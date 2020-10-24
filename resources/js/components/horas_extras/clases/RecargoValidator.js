import { Validator } from './Validator'

/** Clase para la validación de recargos nocturnos */
export class RecargoValidator extends Validator {
  constructor(
    horaDeEntrada = {},
    horaDeSalida = {},
    horaInicioNoche = null,
    horaFinNoche = null
  ) {
    super(horaDeEntrada, horaDeSalida, horaInicioNoche, horaFinNoche)
    this.contadorRecargo = 0
  }

  /** Retorna la cantidad de recargos del funcionario
   *  @return {Number}
   */
  calculoRecargos() {
    let entradaInicial = this.entrada.format('HH:mm:ss')
    let minutos = 0

    while (this.entrada <= this.salida) {
      if (
        this.entradaToMomentString() > this.inicioNocheToMomentString() &&
        this.diferenciaInMinutos(
          this.entradaToMomentString(),
          this.inicioNocheToMomentString()
        ) > 30
      ) {
        this.contadorRecargo++
        minutos = this.diferenciaInMinutos(this.salida, this.entrada)
        /**
         * A partir de las 00:00 es madrugada y no toma el tiempo en este bloque si se laboró después de * esa hora, si los minutos en la última hora despues de las 00:00:00 son mayores a 30 y *menores-iguales a 60,esto quiere decir que se ha trabajado una hora, ejemplo: 23:30 a 00:20, 23:50 a 00:50
         */
        if (minutos > 30 && minutos <= 60) {
          this.contadorRecargo++
        }
      } else if (this.entradaToMomentString() < this.finNocheToMomentString()) {
        this.contadorRecargo++
        minutos = this.diferenciaInMinutos(
          this.finNocheToMomentString(),
          this.entradaToMomentString()
        )
        if (minutos > 30 && minutos <= 60) {
          this.contadorRecargo++
        }
      }
      this.entrada = this.entrada.add(1, 'h')
    }

    /** Verificar si el funcionario ingresó antes de las 06:00am */
    this.ingresoAntes(entradaInicial, this.finNocheToMomentString())

    return this.contadorRecargo
  }

  /** Disminuye el contador en 1 si el funcionario ingresó antes de las 6:00am  (menos de 30 minutos)  (ej: 5:40am,5:50am, 5:55am) , esto debido a que si la entrada es menor a las 6:00am, el contador de recargos aumenta ya que la hora de fin noche es 06:00 am.
   * @param {String }
   * @param {String }
   */
  ingresoAntes(entrada, horaFinNoche) {
    if (
      entrada < horaFinNoche &&
      this.diferenciaInMinutos(entrada, horaFinNoche) < 30
    ) {
      this.contadorRecargo--
    }
  }
}
