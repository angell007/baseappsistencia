import { Validator } from './Validator'

/** Clase para la validación de horas extras dirunas o nocturnas */
export class ExtraValidator extends Validator {
  constructor(horaDeEntrada, horaDeSalida, horaInicioNoche, horaFinNoche) {
    super(horaDeEntrada, horaDeSalida, horaInicioNoche, horaFinNoche)
  }

  /**
   * @param {Object} container Set Contenedor u objeto para guardar las horas calculadas
   */
  register(container = {}) {
    this.container = container
    return this
  }

  /**
   * @param {Number} cantidadHoras Set Jornada laboral ordinaria
   */
  withJornadaLaboral(cantidadHoras = 8) {
    this.jornadaLaboral = cantidadHoras
  }

  /**
   * Comprobar si el tiempo laborado es mayor a la jornada laboral
   * Hacer la diferencia entre el tiempo legal de la jornada y el real laborado
   * Saber si es diurna o nocturna
   * @return null
   */
  calcularExtras() {
    const horasRealesLaboradas = Math.round(
      this.diferenciaInHoras(this.salida, this.entrada)
    )

    if (horasRealesLaboradas > this.jornadaLaboral) {
      const diferencia = horasRealesLaboradas - this.jornadaLaboral

      if (this.salidaToMomentString() < this.entradaToMomentString()) {
        //Extras nocturnas y diurnas cuando la hora de salida es menor que la hora de entrada

        let diferenciaSalida = this.diferenciaInHoras(
          this.salidaToMomentString(),
          this.finNocheToMomentString()
        )

        if (this.salidaToMomentString() > this.finNocheToMomentString()) {
          this.container['horasExtrasDiurnas'] = Math.round(diferenciaSalida)
          this.container['horasExtrasNocturnas'] = Math.abs(
            diferencia - this.container['horasExtrasDiurnas']
          )
        } else {
          this.container['horasExtrasNocturnas'] = diferencia
        }
      } else {
        //Extras diurnas
        if (
          (this.entradaToMomentString() >= this.finNocheToMomentString() ||
            this.diferenciaInMinutos(
              this.finNocheToMomentString(),
              this.entradaToMomentString()
            ) < 30) &&
          this.salidaToMomentString() <= this.inicioNocheToMomentString()
        ) {
          this.container['horasExtrasDiurnas'] = diferencia
        }
        //Extras diurnas y nocturnas cuando la hora de salida es mayor que la hora de entrada
        else if (
          this.entradaToMomentString() >= this.finNocheToMomentString() &&
          this.salidaToMomentString() > this.inicioNocheToMomentString()
        ) {
          let diferenciaSalida = Math.round(
            this.diferenciaInHoras(
              this.salidaToMomentString(),
              this.inicioNocheToMomentString()
            )
          )

          if (diferenciaSalida > diferencia) {
            this.container.horasExtrasNocturnas = diferencia
          } else {
            this.container['horasExtrasNocturnas'] = diferenciaSalida
            this.container['horasExtrasDiurnas'] =
              diferencia - this.container['horasExtrasNocturnas']
          }
        }
      }
    } else {
      // No existen extras
      this.container['horasExtrasNocturnas'] = 0
      this.container['horasExtrasDiurnas'] = 0
    }
  }
}
