const date = new Date();

export const FechaService = {
  getAnoActual() {
    return moment(Date.now()).format("YYYY");
  },
  getMesActual() {
    return moment(Date.now()).format("MM");
  },
  getFechaIncioMesActual() {
    return `01/${moment(Date.now()).format("MM")}/${moment(Date.now()).format(
      "YYYY"
    )}`;
  },
  getFechaFinMesActual() {
    return `${moment(
      new Date(date.getFullYear(), date.getMonth() + 1, 0)
    ).format("DD")}/${moment(Date.now()).format("MM")}/${moment(
      Date.now()
    ).format("YYYY")}`;
  },
  getDiasEntreFechas(fechaInicio, fechaFin) {
    return moment(fechaFin).diff(moment(fechaInicio), "days");
  },
  getParseFecha(fecha) {
    const partesFecha = fecha.split("/");
    const dia = parseInt(partesFecha[0], 10);
    const mes = parseInt(partesFecha[1], 10) - 1; // Restamos 1 al mes porque en JavaScript los meses van de 0 a 11.
    const anio = parseInt(partesFecha[2], 10);
    return new Date(anio, mes, dia);
  },
  ruleDateMinToday(value) {
    if (!value) {
      return "La fecha es obligatoria.";
    }

    const selectedDate = new Date(value);
    const today = new Date();

    if (selectedDate < today) {
      return "La fecha debe ser igual o posterior a hoy.";
    }

    return true; // La validación es exitosa
  },
  getFechaIncioMes(mes, formato = "DD-MM-YYYY") {
    const fechaActual = new Date();
    fechaActual.setMonth(mes - 1);
    fechaActual.setDate(1);
    return moment(fechaActual).format(formato);
  },
  getFechaFinMes(mes, formato = "DD-MM-YYYY") {
    const fechaActual = new Date();
    fechaActual.setMonth(mes);
    fechaActual.setDate(0);
    return moment(fechaActual).format(formato);
  },

  getStartDateOfWeek(year, weekNumber, formato = "DD-MM-YYYY") {
    const startDate = moment()
      .year(year)
      .isoWeek(weekNumber)
      .startOf("isoWeek");
    return startDate.format(formato);
  },

  getEndDateOfWeek(year, weekNumber, formato = "DD-MM-YYYY") {
    const endDate = moment().year(year).isoWeek(weekNumber).endOf("isoWeek");
    return endDate.format(formato);
  },

  getQuincenaDates(year, quincenaNumber, formato = "DD-MM-YYYY") {
    const daysInQuincena = 15;

    const startDate = new Date(year, 0, 1);
    startDate.setDate(1 + (quincenaNumber - 1) * daysInQuincena);

    const endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + daysInQuincena - 1);

    const formattedStartDate = moment(startDate).format(formato);
    const formattedEndDate = moment(endDate).format(formato);

    return { startDate: formattedStartDate, endDate: formattedEndDate };
  },
  getDiaActual() {
    return moment(Date.now()).format("DD");
  },
  getDateToday() {
    return (
      this.getAnoActual() +
      "-" +
      this.getMesActual() +
      "-" +
      this.getDiaActual()
    );
  },
  getDateAddValue(dateString, cantAdd, typeAdded = "days") {
    return moment(dateString).add(cantAdd, typeAdded).format("YYYY-MM-DD");
  },
  getDiasEntreFechas(fechaInicio, fechaFin) {
    return moment(fechaFin).diff(moment(fechaInicio), "days");
  },
  getParseFecha(fecha) {
    const partesFecha = fecha.split("/");
    const dia = parseInt(partesFecha[0], 10);
    const mes = parseInt(partesFecha[1], 10) - 1; // Restamos 1 al mes porque en JavaScript los meses van de 0 a 11.
    const anio = parseInt(partesFecha[2], 10);
    return new Date(anio, mes, dia);
  },
  ruleDateMinToday(value) {
    if (!value) {
      return "La fecha es obligatoria.";
    }

    const selectedDate = new Date(value);
    const today = new Date();

    if (selectedDate < today) {
      return "La fecha debe ser igual o posterior a hoy.";
    }

    return true; // La validación es exitosa
  },
};
