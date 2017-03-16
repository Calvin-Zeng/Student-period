Public Class searchticket
    Inherits System.Web.UI.Page
    Private Sub WebForm1_Init(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Init
        DropDownList3.SelectedValue = DateTime.Now.Hour.ToString & ":00"
        Calendar1.SelectedDate = DateTime.Now.ToString("yyyy/MM/dd")
        If Session("return") = 1 Then
            Button1.Visible = False
            DropDownList1.SelectedValue = Session("endstation")
            DropDownList2.SelectedValue = Session("startstation")
            DropDownList1.Enabled = False
            DropDownList2.Enabled = False
        End If
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load


    End Sub


    Protected Sub Button4_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button4.Click

        If Calendar1.Visible = False Then
            Calendar1.Visible = True
        Else
            Calendar1.Visible = False
        End If


    End Sub

    Protected Sub Button1_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button1.Click
        Dim tmpindex As Integer
        tmpindex = DropDownList1.SelectedIndex
        DropDownList1.SelectedIndex = DropDownList2.SelectedIndex
        DropDownList2.SelectedIndex = tmpindex
    End Sub

    Protected Sub Button2_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button2.Click
        DropDownList3.SelectedValue = DateTime.Now.Hour.ToString & ":00"
        Calendar1.SelectedDate = DateTime.Now.ToString("yyyy/MM/dd")
        Calendar1.VisibleDate = DateTime.Now.ToString("yyyy/MM/dd")
    End Sub

    Protected Sub Button3_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button3.Click
        If Session("return") = 1 Then
            Session("returnstartstation") = DropDownList1.SelectedValue
            Session("returnendstation") = DropDownList2.SelectedValue
            Session("returndate") = Calendar1.SelectedDate
            Session("returnstationtime") = DropDownList3.SelectedValue
            Session("returnday") = Calendar1.SelectedDate.DayOfWeek.ToString

        Else
            Session("startstation") = DropDownList1.SelectedValue
            Session("endstation") = DropDownList2.SelectedValue
            Session("date") = Calendar1.SelectedDate
            Session("stationtime") = DropDownList3.SelectedValue
            Session("day") = Calendar1.SelectedDate.DayOfWeek.ToString

            'Session("time") = DateTime.Now.Hour.ToString

        End If





        If DropDownList1.SelectedIndex < DropDownList2.SelectedIndex Then
            Session("direction") = "南下"
            Response.Redirect("result.aspx")
        ElseIf DropDownList1.SelectedIndex > DropDownList2.SelectedIndex Then
            Session("direction") = "北上"
            Response.Redirect("result.aspx")
        Else
            Label1.Text = "站別重複,請選擇其他到達地"
        End If


    End Sub

    Private Sub Calendar1_DayRender(ByVal sender As Object, ByVal e As System.Web.UI.WebControls.DayRenderEventArgs) Handles Calendar1.DayRender
        If e.Day.Date < DateTime.Now.Date Then
            e.Day.IsSelectable = False
        End If
        If e.Day.Date > DateTime.Now.Date.AddDays(27) Then
            e.Day.IsSelectable = False

        End If
    End Sub

    Protected Sub Button5_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button5.Click
        Me.Session.Clear()
        Response.Redirect("searchticket.aspx")
    End Sub
End Class