Public Class booking
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Label1.Text = Session("startstation") & "→" & Session("endstation")
        Label6.Text = Session("date") & "  " & Session("stime") & "→" & Session("etime")
        Label7.Text = Session("number") & " 車次"
        If Session("return") = 1 Then
            'Button1.Visible = False
            Label15.Visible = True
            Label16.Visible = True
            Label15.Text = Session("returndate") & "  " & Session("returnstime") & "→" & Session("returnetime")
            Label16.Text = Session("returnnumber") & " 車次"
            Button1.Text = "X"
        End If

    End Sub

    Protected Sub Button2_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button2.Click
        Dim ticketnum As Integer
        ticketnum = CInt(DropDownList1.SelectedValue) + CInt(DropDownList2.SelectedValue) + CInt(DropDownList3.SelectedValue) + CInt(DropDownList4.SelectedValue)
        If Session("return") = 1 Then
            If ticketnum > 5 Then
                System.Web.HttpContext.Current.Response.Write("<script language=javascript>alert('每筆交易最多可訂10張票(去回程最多5張)')</script>")
            Else
                Session("returnfcount") = DropDownList1.SelectedValue
                Session("returnccount") = DropDownList2.SelectedValue
                Session("returnocount") = DropDownList3.SelectedValue
                Session("returnlcount") = DropDownList4.SelectedValue
                If RadioButton1.Checked = True Then
                    Session("returncarcate") = 0
                Else
                    Session("returncarcate") = 1
                End If
                Response.Redirect("ticketinfo.aspx")
            End If
        Else
            If ticketnum > 10 Then
                System.Web.HttpContext.Current.Response.Write("<script language=javascript>alert('每筆交易最多可訂10張票(去回程最多5張)')</script>")
            Else
                Session("fcount") = DropDownList1.SelectedValue
                Session("ccount") = DropDownList2.SelectedValue
                Session("ocount") = DropDownList3.SelectedValue
                Session("lcount") = DropDownList4.SelectedValue
                If RadioButton1.Checked = True Then
                    Session("carcate") = 0
                Else
                    Session("carcate") = 1
                End If
                Response.Redirect("ticketinfo.aspx")
            End If
        End If




    End Sub

    Protected Sub Button1_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button1.Click
        If Button1.Text = "X" Then
            Session("return") = 0
            Label15.Visible = False
            Label16.Visible = False
            Button1.Text = "尚未選擇回程車次"
        Else
            Session("return") = 1
            Response.Redirect("searchticket.aspx")
        End If


    End Sub
End Class