  function generaPDF(base64,worker){
    // If absolute URL from the remote server is provided, configure the CORS
    // header on that server.
    var pdfbase64 = window.atob(base64);
    // The workerSrc property shall be specified.
    PDFJS.workerSrc = worker;
    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1,
        canvas = document.getElementById('pdf_scg'),
        ctx = canvas.getContext('2d');
    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
      pageRendering = true;
      // Using promise to fetch the page
      pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        var renderTask = page.render(renderContext);
        // Wait for rendering to finish
        renderTask.promise.then(function() {
          pageRendering = false;
          if (pageNumPending !== null) {
            // New page rendering is pending
            renderPage(pageNumPending);
            pageNumPending = null;
          }
        });
      });
      // Update page counters
      document.getElementById('page_num').textContent = pageNum;
    }
    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
      if (pageRendering) {
        pageNumPending = num;
      } else {
        renderPage(num);
      }
    }
    function onZoomIn(){
      if (scale >= 6) {
        return;
      }
      scale++;
      var num = pageNum;
      queueRenderZoom(num, scale);
    }
    document.getElementById('zoom_in').addEventListener('click', onZoomIn);
    
    function onZoomOut(){
      if (scale <= 1) {
        return;
      }
      scale--;
      var num = pageNum;
      queueRenderZoom(num, scale);
    }
    document.getElementById('zoom_out').addEventListener('click', onZoomOut);
    

    function queueRenderZoom(num, scale) {
      pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        var renderTask = page.render(renderContext);
      });
    }
    /**
     * Displays previous page.
     */
    function onPrevPage() {
      if (pageNum <= 1) {
        return;
      }
      pageNum--;
      queueRenderPage(pageNum);
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);
    /**
     * Displays next page.
     */
    function onNextPage() {
      if (pageNum >= pdfDoc.numPages) {
        return;
      }
      pageNum++;
      queueRenderPage(pageNum);
    }
    document.getElementById('next').addEventListener('click', onNextPage);
    /**
     * Asynchronously downloads PDF.
     */
    PDFJS.getDocument({data:pdfbase64}).then(function(pdfDoc_) {
      pdfDoc = pdfDoc_;
      document.getElementById('page_count').textContent = pdfDoc.numPages;
      // Initial/first page rendering
      renderPage(pageNum);
    });

    // function downloadPDF(){
    //   var a = document.createElement('a');;
    //   var pdfAsDataUri = "data:application/pdf;base64,"+base64;
    //   a.download = 'document.pdf';
    //   a.type = 'application/pdf';
    //   a.href = pdfAsDataUri;
    //   a.click();
    // }
    // document.getElementById('download').addEventListener('click', downloadPDF);
  }