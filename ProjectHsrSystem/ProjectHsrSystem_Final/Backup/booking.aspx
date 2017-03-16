<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="booking.aspx.vb" Inherits="ProjectHsrSystem_Final.booking" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>高鐵查/訂票系統</title>
<link rel=stylesheet type="text/css" href="layout.css">
</head>

<body>
<div id="wrapper">
<div id="header">
  <h1>高鐵查/訂票系統</h1>
</div>
<div id="siderbar">
<div id="siderbar_content">
  <p><a href="default.aspx"><img src="images/home.png" width="170" height="57" alt="首頁" /></a></p>
  <p><a href="searchticket.aspx"><img src="images/book.png" width="170" height="57" alt="查/訂票" /></a></p>
  <p><a href="login.aspx"><img src="images/detail.png" width="170" height="52" alt="查詢訂票紀錄"/></a></p>
  <ul>
    <li><a href="login.aspx"><img src="images/cancel.png" width="170" height="57" alt="取消訂票"/></a></li>
  </ul>
  <p><a href="manual.aspx"><img src="images/manual.png" width="170" height="57" alt="使用說明" /></a></p>
  <p><a href="about.aspx"><img src="images/about.png" width="170" height="57" alt="關於我們"/></a></p>
  <p>&nbsp;</p>
</div>

</div>
<div id="content">
  <div id="content_u"></div>
  <div id="content_m">
<form id="form1" runat="server">
        <table align="center" style="width: 80%; margin-left:auto; margin-right:auto;">
            <tr>
                <td class="style3" colspan="9" style="text-align: center">
                    <asp:Label ID="Label1" runat="server" Text="Label" style="text-align: left"></asp:Label>
                </td>
            </tr>
            <tr>
                <td style="text-align: center" rowspan="2">
                    <asp:Label ID="Label2" runat="server" Text="去程"></asp:Label>
                </td>
                <td colspan="8" style="text-align: left">
                    <asp:Label ID="Label6" runat="server" Text="Label" style="text-align: left"></asp:Label>
                </td>
            </tr>
            <tr>
                <td class="style3" colspan="8" style="text-align: left">
                    <asp:Label ID="Label7" runat="server" Text="Label" style="text-align: left"></asp:Label>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <asp:Label ID="Label3" runat="server" Text="回程"></asp:Label>
                </td>
                <td colspan="7" style="text-align: left">
                    <asp:Label ID="Label15" runat="server" Text="Label" Visible="False"></asp:Label>
                    <br />
                    <asp:Label ID="Label16" runat="server" Text="Label" Visible="False"></asp:Label>
                    <asp:Button ID="Button1" runat="server" Text="尚未選擇回程車次" CssClass="b1" />
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center" rowspan="3">
                    <asp:Label ID="Label4" runat="server" Text="票數"></asp:Label>
                </td>
                <td style="text-align: center">
                    <asp:Label ID="Label10" runat="server" Text="全票"></asp:Label>
                </td>
                <td colspan="2" style="text-align: center">
                    <asp:DropDownList ID="DropDownList1" runat="server">
                        <asp:ListItem>0</asp:ListItem>
                        <asp:ListItem Selected="True">1</asp:ListItem>
                        <asp:ListItem>2</asp:ListItem>
                        <asp:ListItem>3</asp:ListItem>
                        <asp:ListItem>4</asp:ListItem>
                        <asp:ListItem>5</asp:ListItem>
                        <asp:ListItem>6</asp:ListItem>
                        <asp:ListItem>7</asp:ListItem>
                        <asp:ListItem>8</asp:ListItem>
                        <asp:ListItem>9</asp:ListItem>
                        <asp:ListItem>10</asp:ListItem>
                    </asp:DropDownList>
                </td>
                <td style="text-align: center">
                    <asp:Label ID="Label11" runat="server" Text="孩童票"></asp:Label>
                </td>
                <td style="text-align: center">
                    <asp:DropDownList ID="DropDownList2" runat="server">
                        <asp:ListItem>0</asp:ListItem>
                        <asp:ListItem>1</asp:ListItem>
                        <asp:ListItem>2</asp:ListItem>
                        <asp:ListItem>3</asp:ListItem>
                        <asp:ListItem>4</asp:ListItem>
                        <asp:ListItem>5</asp:ListItem>
                        <asp:ListItem>6</asp:ListItem>
                        <asp:ListItem>7</asp:ListItem>
                        <asp:ListItem>8</asp:ListItem>
                        <asp:ListItem>9</asp:ListItem>
                        <asp:ListItem>10</asp:ListItem>
                    </asp:DropDownList>
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <asp:Label ID="Label12" runat="server" Text="敬老票"></asp:Label>
                </td>
                <td colspan="2" style="text-align: center">
                    <asp:DropDownList ID="DropDownList3" runat="server">
                        <asp:ListItem>0</asp:ListItem>
                        <asp:ListItem>1</asp:ListItem>
                        <asp:ListItem>2</asp:ListItem>
                        <asp:ListItem>3</asp:ListItem>
                        <asp:ListItem>4</asp:ListItem>
                        <asp:ListItem>5</asp:ListItem>
                        <asp:ListItem>6</asp:ListItem>
                        <asp:ListItem>7</asp:ListItem>
                        <asp:ListItem>8</asp:ListItem>
                        <asp:ListItem>9</asp:ListItem>
                        <asp:ListItem>10</asp:ListItem>
                    </asp:DropDownList>
                </td>
                <td style="text-align: center">
                    <asp:Label ID="Label13" runat="server" Text="愛心票"></asp:Label>
                </td>
                <td style="text-align: center">
                    <asp:DropDownList ID="DropDownList4" runat="server">
                        <asp:ListItem>0</asp:ListItem>
                        <asp:ListItem>1</asp:ListItem>
                        <asp:ListItem>2</asp:ListItem>
                        <asp:ListItem>3</asp:ListItem>
                        <asp:ListItem>4</asp:ListItem>
                        <asp:ListItem>5</asp:ListItem>
                        <asp:ListItem>6</asp:ListItem>
                        <asp:ListItem>7</asp:ListItem>
                        <asp:ListItem>8</asp:ListItem>
                        <asp:ListItem>9</asp:ListItem>
                        <asp:ListItem>10</asp:ListItem>
                    </asp:DropDownList>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center">
                    <asp:Label ID="Label14" runat="server" Text="註:每筆交易最多可訂10張票(去回程最多5張)"></asp:Label>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">
                    <asp:Label ID="Label5" runat="server" Text="車廂"></asp:Label>
                </td>
                <td colspan="3" style="text-align: center">
                    <asp:RadioButton ID="RadioButton1" runat="server" Checked="True" 
                        GroupName="test" Text="標準車廂" />
                </td>
                <td colspan="3" style="text-align: center">
                    <asp:RadioButton ID="RadioButton2" runat="server" GroupName="test" 
                        Text="商務車廂" />
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: center">
                    <asp:Button ID="Button2" runat="server" Text="下一步" CssClass="b1" />
                </td>
            </tr>
        </table>
    </form>
  </div>
  <div id="content_d"></div>
  
</div>
<div id="footer">高鐵查/訂票系統 版權所有 明新科技大學-蔡旻晃/陳致翰/曾啟倫 版面樣式：曾啟倫</div>
</div>

</body>
</html>