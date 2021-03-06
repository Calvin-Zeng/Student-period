USE [Trains]
GO
/****** Object:  Table [dbo].[orderinfo]    Script Date: 12/17/2012 10:27:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[orderinfo](
	[id] [varchar](30) NOT NULL,
	[phone] [varchar](30) NOT NULL,
	[ordertime] [varchar](30) NOT NULL,
	[start_station] [varchar](30) NOT NULL,
	[end_station] [varchar](30) NOT NULL,
	[train_id] [int] NOT NULL,
	[wayticket] [varchar](30) NOT NULL,
	[returntrain_id] [int] NULL,
	[code] [varchar](30) NOT NULL,
 CONSTRAINT [PK_orderinfo] PRIMARY KEY NONCLUSTERED 
(
	[code] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
