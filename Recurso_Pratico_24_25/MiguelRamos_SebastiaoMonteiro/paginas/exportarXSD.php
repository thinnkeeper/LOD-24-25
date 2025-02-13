<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        // Criar o conteúdo do XSD
        $xsdContent = '<?xml version="1.0" encoding="UTF-8"?>
        <xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <xs:element name="formacoesLW">
                <xs:complexType>
                    <xs:sequence>
                        <xs:element name="utilizadores">
                            <xs:complexType>
                                <xs:sequence>
                                    <xs:element name="utilizador" maxOccurs="unbounded">
                                        <xs:complexType>
                                            <xs:sequence>
                                                <xs:element name="id" type="xs:int"/>
                                                <xs:element name="nomeUtilizador" type="xs:string"/>
                                                <xs:element name="email" type="xs:string"/>
                                                <xs:element name="tipoUtilizador" type="xs:string"/>
                                            </xs:sequence>
                                        </xs:complexType>
                                    </xs:element>
                                </xs:sequence>
                            </xs:complexType>
                        </xs:element>
                        <xs:element name="formacoes">
                            <xs:complexType>
                                <xs:sequence>
                                    <xs:element name="formacao" maxOccurs="unbounded">
                                        <xs:complexType>
                                            <xs:sequence>
                                                <xs:element name="codigoFormacao" type="xs:string"/>
                                                <xs:element name="nome" type="xs:string"/>
                                                <xs:element name="descricao" type="xs:string"/>
                                                <xs:element name="data" type="xs:date"/>
                                                <xs:element name="docenteID" type="xs:int"/>
                                                <xs:element name="horaInicio" type="xs:time"/>
                                                <xs:element name="duracao" type="xs:int"/>
                                                <xs:element name="lotacao" type="xs:int"/>
                                            </xs:sequence>
                                        </xs:complexType>
                                    </xs:element>
                                </xs:sequence>
                            </xs:complexType>
                        </xs:element>
                    </xs:sequence>
                </xs:complexType>
            </xs:element>
        </xs:schema>';

        // Guardar o XSD num ficheiro
        $filename = "formacoesLW.xsd";
        file_put_contents($filename, $xsdContent);

        // Download do XSD
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);

        // Remover o ficheiro após o download
        // unlink($filename);
    }
?>
