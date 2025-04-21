function descargar(data, nombreArchivo) {
  const link = document.createElement("a");
  link.href = window.URL.createObjectURL(new Blob([data]));
  link.download = nombreArchivo;
  link.click();
}

function getFileName(headers) {
  const contentDispositionHeader = headers["content-disposition"];
  const regex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/i;
  const match = contentDispositionHeader.match(regex);
  return match[1].replace(/['"]/g, "");
}

export default {
  descargar,
  getFileName,
};
