<?php

/*
 * Copyright (C) 2014 Pedro Gabriel Manrique Gutiérrez <pedrogmanrique at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class PdfController extends Controller
{
    private $_pdf;
    
    public $family = "Arial";
    private $style = "b";
    private $size = "60";
    private $cuerpo = "Hola Mundito!! ";


    public function __construct() {
        parent::__construct();
        $this->getLibrary('fpdf');
        $this->_pdf = new FPDF(); // 
    }
    // Es obligado el método index
    public function index(){
        
    }
    
    public function creaPdf($cuerpo)
    {
        $this->_pdf->AddPage();
        $this->_pdf->SetFont($this->family, $this->style, $this->size);
        $this->_pdf->Cell(40,10, utf8_decode($cuepo));
        $this->_pdf->Output();
    }
    
    
    
}
