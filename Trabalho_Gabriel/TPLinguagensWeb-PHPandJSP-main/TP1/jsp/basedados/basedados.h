<%@ page language="java" import="java.sql.*" %>
<%
    String URL = "jdbc:mysql://localhost:3306/gestao_cursos";
    String USER = "root";
    String PASSWORD = "";
    Connection conn = null;

    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
        conn = DriverManager.getConnection(URL, USER, PASSWORD);
    } catch (ClassNotFoundException | SQLException e) {
        e.printStackTrace();
    }
%>
