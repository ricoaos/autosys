<?php 

//cria objeto
$pdf = new Zend_Pdf();

/* Cria uma nova página pdf, neste caso define tamanho de folha A4
 * Poderíamos usar da seguinte maneira: $pdf->newPage($x, $y) tamanho em px
 * exemplo: $pdf->newPage('500', '500');
 * A4 modo paisagem = SIZE_A4_LANDSCAPE
 */

$pdfPage = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);

// Busca uma fonte para usarmos, neste caso: courier, poderíamos usar _VERDANA, etc...
$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);

// Aplica fonte
$pdfPage->setFont($font, 12);

/*
 * Como o próprio nome diz: escreve o texto;
 * os principais parâmetros dessa função são: (texto, posx, posy, encoding);
 * no meu caso, encodei para UTF-8, pois os dados que estou escrevendo também
 * estão nesse o formato.
 * Caso você tenha problemas com acentuação, retire esta propriedade
 */

$pdfPage->drawText('Under-Linux',45, 800,'UTF-8');

/*
 * reparem que eu usei a mesma fonte, mas alterei seu tamanho;
 * do mesmo modo, você pode criar várias fontes e antes de escrever o texto, setá-las;
 */
$pdfPage->setFont($font, 10);
$pdfPage->drawText('www.under-linux.com.br',45, 784,'UTF-8');

//Trabalhando com quebras de linhas: wordwrap

$texto = 'Foi anunciado o lançamento da série M5 para o Eclipse 3.6, também denominado Hélio, em homenagem ao Deus Grego do Sol. Com base em versões anteriores, o Eclipse 3.6 M5 inclui diversas correções de bugs e apresenta novas funcionalidades.';

//faz a quebra em php para cada 60 caracteres
$conc = wordwrap($texto, 60, '\n');
$d = explode('\n', $conc);

$stringpos = 780; // posicao x do meu texto
$stringdif = 12; // diferença entre cada quebra de linha.

$pdfPage->setFont($font, 9); //

foreach($d as $c)
{
    $pdfPage->drawText($c, 260, $stringpos, 'UTF-8');
    $stringpos = ($stringpos-$stringdif); //subtrai para que a linha fique embaixo
}

// adicionamos nossa página como a 1ª página de nosso documento
$pdf->pages[0]= $pdfPage;

//Salvamos o documento Obs.: requer permissão para escrita na pasta (CHMOD);
$pdf->save('exemplo.pdf');

//Por fim, setamos a header como um PDF, e renderizamos o nosso $pdf;
header('Content-type: application/pdf');
echo $pdf->render();  