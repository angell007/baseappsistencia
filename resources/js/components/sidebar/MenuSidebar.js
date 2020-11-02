export default {
  menuItems: [
    //{ item: 'Nómina', icon: 'iconsmind-Money-Bag' },
    { item: 'Novedades', icon: 'iconsmind-Ticket' },
    { item: 'Horarios', icon: 'iconsmind-Clock' },
    // { item: 'App', icon: 'iconsmind-Smartphone-2' },
    { item: 'Indicadores', icon: 'iconsmind-Line-Chart3' },
    { item: 'Configuración', icon: 'iconsmind-Gears-2' },
    //{ item: 'Administrativo', icon: 'iconsmind-Control' },
  ],
  submenuItems: [
    /*{
      item: 'Nómina',
      listItems: [
        {
          item: 'Pago de Nómina',
          icon: 'simple-icon-wallet',
          url: '/nomina/pago',
        },
        {
          item: 'Historial de Pagos',
          icon: 'simple-icon-briefcase',
          url: '/nomina/historial-pagos',
        },
        {
          item: 'Provisiones',
          icon: 'simple-icon-umbrella',
          url: '/nomina/provisiones',
        },
        {
          item: 'Liquidaciones',
          icon: 'simple-icon-people',
          url: '/nomina/liquidaciones',
        },
      ],
    },*/
    {
      item: 'Novedades',
      listItems: [
        {
          item: 'Listado de Novedades',
          icon: 'simple-icon-bell',
          url: '/novedades',
        },

        {
          item: 'Llegadas Tarde',
          icon: 'simple-icon-hourglass',
          url: '/llegadas_tarde',
        },
      ],
    },
    {
      item: 'Horarios',
      listItems: [
        {
          item: 'Turnos',
          icon: 'simple-icon-plus',
          url: '/turnos',
        },

        {
          item: 'Asignación de turnos',
          icon: 'simple-icon-calendar',
          url: '/horarios',
        },
        {
          item: 'Reporte Horarios',
          icon: 'simple-icon-info',
          url: '/reporte/horarios',
        },
        /*{
          item: 'Valid. Horas Extras',
          icon: 'simple-icon-check',
          url: '/horas_extras',
        },*/
      ],
    },
    // {
    //   item: 'App',
    //   listItems: [
    //     {
    //       item: 'Alertas y Mensajes',
    //       icon: 'simple-icon-envelope-letter',
    //       url: '/',
    //     },

    //     {
    //       item: 'Blog',
    //       icon: 'simple-icon-notebook',
    //       url: 'nomina/provisiones',
    //     },
    //     {
    //       item: 'Docs. Empresa',
    //       icon: 'simple-icon-docs',
    //       url: '/',
    //     },
    //   ],
    // },
    {
      item: 'Indicadores',
      listItems: [
        {
          item: 'Ind. Novedades',
          icon: 'simple-icon-support',
          url: '/indicadores/novedades',
        },

        {
          item: 'Ind. Llegada Tarde',
          icon: 'simple-icon-clock',
          url: '/indicadores/tiempo',
        },
      ],
    },
    {
      item: 'Configuración',
      listItems: [
        {
            item: 'Información General',
            icon: 'simple-icon-briefcase',
            url: '/general/empresa',
        },
        {
            item: 'C. de Costos',
            icon: 'simple-icon-home',
            url: '/centros_costos',
        },
        {
            item: 'Dependencias',
            icon: 'simple-icon-star',
            url: '/dependencias',
        },
        {
            item: 'Cargos',
            icon: 'simple-icon-tag',
            url: '/cargos',
        },
        {
            item: 'Tipos de Contrato',
            icon: 'simple-icon-layers',
            url: '/contratos',
        },
        {
          item: 'Funcionarios',
          icon: 'simple-icon-people',
          url: '/funcionarios',
        },
        /*{
          item: 'Eps',
          icon: 'simple-icon-shield',
          url: '/eps',
        },
        {
          item: 'Cajas de Comp.',
          icon: 'simple-icon-present',
          url: '/compensaciones',
        },
        {
          item: 'Fondos Cesantías',
          icon: 'simple-icon-credit-card',
          url: '/cesantias',
        },
        {
          item: 'Fondos Pensiones',
          icon: 'simple-icon-eyeglass',
          url: '/pensiones',
        },
        {
          item: 'Parametrización',
          icon: 'simple-icon-list',
          url: '/parametrizacion',
        },*/
        {
            item: 'Encuestas',
            icon: 'iconsmind-Check',
            url: '/encuestas',
          },
       /* {
          item: 'Formatos',
          icon: 'simple-icon-docs',
          url: '/formatos',
        },*/
      ],
    },
    /*{
        item: 'Administrativo',
        listItems: [
          {
            item: 'Clientes',
            icon: 'iconsmind-Network',
            url: '/administrativo/clientes',
          },

          {
            item: 'Solicitudes Soporte',
            icon: 'iconsmind-Consulting',
            url: '/administrativo/soporte',
          },
        ],
      },*/
  ],
}
