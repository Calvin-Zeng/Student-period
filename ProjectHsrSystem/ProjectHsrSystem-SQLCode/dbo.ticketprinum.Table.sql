USE [Trains]
GO
/****** Object:  Table [dbo].[ticketprinum]    Script Date: 12/17/2012 10:27:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ticketprinum](
	[code] [varchar](30) NOT NULL,
	[price] [int] NOT NULL,
	[cate] [int] NOT NULL,
	[fcount] [int] NOT NULL,
	[ccount] [int] NOT NULL,
	[ocount] [int] NOT NULL,
	[lcount] [int] NOT NULL,
 CONSTRAINT [PK_ticketprinum] PRIMARY KEY NONCLUSTERED 
(
	[code] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
