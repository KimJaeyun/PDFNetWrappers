<?php
//---------------------------------------------------------------------------------------
// Copyright (c) 2001-2014 by PDFTron Systems Inc. All Rights Reserved.
// Consult LICENSE.txt regarding license information.
//---------------------------------------------------------------------------------------
include("../../../PDFNetC/Lib/PDFNetPHP.php");

//---------------------------------------------------------------------------------------
// The following sample illustrates how to use the PDF::Convert utility class to convert 
// documents and files to PDF, XPS, SVG, or EMF.
//
// Certain file formats such as XPS, EMF, PDF, and raster image formats can be directly 
// converted to PDF or XPS. Other formats are converted using a virtual driver. To check 
// if ToPDF (or ToXPS) require that PDFNet printer is installed use Convert::RequiresPrinter(filename). 
// The installing application must be run as administrator. The manifest for this sample 
// specifies appropriate the UAC elevation.
//
// Note: the PDFNet printer is a virtual XPS printer supported on Vista SP1 and Windows 7.
// For Windows XP SP2 or higher, or Vista SP0 you need to install the XPS Essentials Pack (or 
// equivalent redistributables). You can download the XPS Essentials Pack from:
//		http://www.microsoft.com/downloads/details.aspx?FamilyId=B8DCFFDD-E3A5-44CC-8021-7649FD37FFEE&displaylang=en
// Windows XP Sp2 will also need the Microsoft Core XML Services (MSXML) 6.0:
// 		http://www.microsoft.com/downloads/details.aspx?familyid=993C0BCF-3BCF-4009-BE21-27E85E1857B1&displaylang=en
//
// Note: Convert.FromEmf and Convert.ToEmf will only work on Windows and require GDI+.
//
// Please contact us if you have any questions.	
//---------------------------------------------------------------------------------------

// Relative path to the folder containing the test files.
$inputPath = getcwd()."/../../TestFiles/";
$outputPath = $inputPath."Output/";

function ConvertToPdfFromFile()
{
	global $inputPath, $outputPath;

    $testfiles = array(
        array("butterfly.png", "png2pdf.pdf"),
		array("simple-xps.xps", "xps2pdf.pdf")
    );
    
    foreach ($testfiles as &$testfile) {
		$pdfdoc = new PDFDoc();
		$inputFile = $inputPath.($testfile[0]);
		$outputFile = $outputPath.($testfile[1]);
		Convert::ToPdf($pdfdoc, $inputFile);
		$pdfdoc->Save($outputFile, SDFDoc::e_compatibility);
        $pdfdoc->Close();
		echo(nl2br("Converted file: ".$inputFile."\n"));
		echo(nl2br("    to: ".$outputFile."\n"));
    }
}

function ConvertSpecificFormats()
{
	global $inputPath, $outputPath;

	$pdfdoc = new PDFDoc();
	$s1 = $inputPath."simple-xps.xps";

	// Convert the XPS document to PDF
	echo(nl2br("Converting from XPS " .$s1."\n"));
	Convert::FromXps($pdfdoc, $s1 );
	$outputFile = $outputPath."pdf_from_xps.pdf";
	$pdfdoc->Save($outputFile, SDFDoc::e_remove_unused);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert the two page PDF document to SVG
	echo(nl2br("Converting pdfdoc to SVG\n"));
	$outputFile = $outputPath."pdf2svg.svg";
	Convert::ToSvg($pdfdoc, $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert the PDF document to XPS
	echo(nl2br("Converting pdfdoc to XPS\n"));
	$outputFile = $outputPath."pdfdoc2xps.xps";
	Convert::ToXps($pdfdoc, $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert the PNG image to XPS
	echo(nl2br("Converting PNG to XPS\n"));
	$outputFile = $outputPath."png2xps.xps";
	Convert::ToXps($inputPath."butterfly.png", $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert PDF document to XPS
	echo(nl2br("Converting PDF to XPS\n"));
	$outputFile = $outputPath."pdf2xps.xps";
	Convert::ToXps($inputPath."newsletter.pdf", $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert PDF document to HTML
	echo(nl2br("Converting PDF to HTML\n"));
	$outputFile = $outputPath."pdf2html";
	Convert::ToHtml($inputPath."newsletter.pdf", $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));

	// Convert PDF document to EPUB
	echo(nl2br("Converting PDF to EPUB\n"));
	$outputFile = $outputPath."pdf2epub.epub";
	Convert::ToEpub($inputPath."newsletter.pdf", $outputFile);
	echo(nl2br("Saved ".$outputFile."\n"));
}

function main()
{
	// The first step in every application using PDFNet is to initialize the 
	// library. The library is usually initialized only once, but calling 
	// Initialize() multiple times is also fine.
	PDFNet::Initialize();
	
	// Demonstrate Convert::ToPdf and Convert::Printer
	ConvertToPdfFromFile();
	
	// Demonstrate Convert::[FromEmf, FromXps, ToEmf, ToSVG, ToXPS]
	ConvertSpecificFormats();

	echo(nl2br("Done.\n"));
}

main();
?>
