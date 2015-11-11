%
% Răzvan Deaconescu <razvan.deaconescu@cs.pub.ro>, 2015
%
% LaTeX class to create lab registers
%
% Inspired by exam.cs.pub.ro.cls by Vlad Dogaru
%
% This work is available under the LaTeX Project Public License version 1.3.
% Copyright notice: you must keep the original author(s)/copyright
% information in the files.
%

\NeedsTeXFormat{LaTeX2e}
\ProvidesClass{register}[2015/10/31]

\LoadClass[a4paper,10pt,oneside,final]{article}

% Specify course name as a class option.
\DeclareOption{uso}{
  \def\@course{Utilizarea Sistemelor de Operare}
  \def\@courselogo{img/uso}
  \def\@courselogoscale{0.08}
}
\DeclareOption{iocla}{
  \def\@course{Introducere în Organizarea Calculatorului și Limbaj de Asamblare}
  \def\@courselogo{img/iocla}
  \def\@courselogoscale{0.2}
}
\DeclareOption{rl}{
  \def\@course{Rețele Locale}
  \def\@courselogo{img/rl}
  \def\@courselogoscale{0.08}
}
\DeclareOption{so}{
  \def\@course{Sisteme de Operare}
  \def\@courselogo{img/so}
  \def\@courselogoscale{0.08}
}
\DeclareOption{pr}{
  \def\@course{Proiectarea Rețelelor}
  \def\@courselogo{img/pr}
  \def\@courselogoscale{0.08}
}
\DeclareOption{cpl}{
  \def\@course{Compilatoare}
  \def\@courselogo{img/cpl}
  \def\@courselogoscale{0.06}
}
\DeclareOption{so2}{
  \def\@course{Sisteme de Operare 2}
  \def\@courselogo{img/so2}
  \def\@courselogoscale{0.08}
}
\DeclareOption{soa}{
  \def\@course{Sisteme de Operare Avansate}
  \def\@courselogo{img/soa}
  \def\@courselogoscale{0.08}
}
\DeclareOption{osp}{
  \def\@course{Operating Systems (practical)}
  \def\@courselogo{img/osp}
  \def\@courselogoscale{0.08}
}
\DeclareOption{cns}{
  \def\@course{Computer and Network Security}
  \def\@courselogo{img/cns}
  \def\@courselogoscale{0.08}
}
\DeclareOption{scr}{
  \def\@course{Securitatea Calculatoarelor și Rețelelor}
  \def\@courselogo{img/scr}
  \def\@courselogoscale{0.08}
}
\DeclareOption{gsr}{
  \def\@course{Gestiunea Serviciilor de Rețea}
  \def\@courselogo{img/gsr}
  \def\@courselogoscale{0.08}
}
\DeclareOption{saisp}{
  \def\@course{Servicii Avansate pentru ISP}
  \def\@courselogo{img/saisp}
  \def\@courselogoscale{0.08}
}
\DeclareOption{sred}{
  \def\@course{Securizarea Rețelelor cu Echipamente Dedicate}
  \def\@courselogo{img/sred}
  \def\@courselogoscale{0.08}
}
\DeclareOption{etm}{
  \def\@course{Instrumente Informatice pentru Antreprenoriat și Management Tehnologic}
  \def\@courselogo{img/etm}
  \def\@courselogoscale{0.08}
}
\DeclareOption{asc}{
  \def\@course{Arhitectura Sistemelor de Calcul}
  \def\@courselogo{img/asc}
  \def\@courselogoscale{0.3}
}
\DeclareOption{app}{
  \def\@course{Arhitecturi și Prelucrări Paralele}
  \def\@courselogo{img/app}
  \def\@courselogoscale{0.08}
}
\DeclareOption{mps}{
  \def\@course{Managementul Proiectelor Software}
  \def\@courselogo{img/mps}
  \def\@courselogoscale{0.2}
}
% Use this option if the layout should be two sets per page.
\DeclareOption{twosetsperpage}{\def\@twosets}
\ProcessOptions

\usepackage{kvoptions}

% How long should a row strecth (in height)
\DeclareStringOption[1.25]{rowstretch}[1.25]

% Number of rows in table
\DeclareStringOption[15]{numrows}[15]

\ProcessKeyvalOptions*

\usepackage{ucs}
\usepackage[utf8x]{inputenc}
\PrerenderUnicode{ăĂâÂîÎșȘțȚ}
\usepackage[english,romanian]{babel}

\usepackage[top=1cm,bottom=1cm,left=1cm,right=1cm]{geometry}
\usepackage{underscore}
\usepackage{forloop}
\usepackage{array}

\usepackage{graphicx}
\DeclareGraphicsExtensions{.pdf,.png,.jpg}

% No page numbers
\pagestyle{empty}

\setlength{\parindent}{0pt}
\setlength{\parskip}{0pt}

% Organization (i.e. department) logo
\def\@orglogo{img/cse-full}
\def\@orglogoscale{0.06}

% Use palatino font.
\renewcommand*\rmdefault{cmss}

% Render the actual register.
\newcounter{rowctr}
\newcolumntype{C}[1]{>{\centering\arraybackslash}m{#1}}
\newcommand\theregister{
  \renewcommand{\arraystretch}{\register@rowstretch}
  \begin{center}
    \centering
    \begin{tabular}{| C{0.5cm} | C{7.5cm} | C{1.5cm} | C{6.5cm} | }
      \hline
      \textbf{Nr} & \textbf{Nume și prenume} & \textbf{Grupă} & \textbf{Activitate} \\
      \hline
      \forloop{rowctr}{1}{\value{rowctr} < \register@numrows}{
        \textbf{\arabic{rowctr}} & & & \\
        \hline
      }
      \textbf{\arabic{rowctr}} & & & \\
      \hline
    \end{tabular}
  \end{center}
}

% Header which includes the logos for course and university
\newcommand\header{
  \raisebox{-.3\height}{\includegraphics[scale=\@courselogoscale]{\@courselogo}}
  \hfill
  {
    \large
    \textbf{Asistent} \underline{\hspace{2cm}}
    \enskip
    \textbf{Laborator} \underline{\hspace{1cm}}
    \enskip
    \textbf{Dată/oră} \underline{\hspace{4cm}}
    \enskip
  }
  \hfill
  \raisebox{-.3\height}{\includegraphics[scale=\@orglogoscale]{\@orglogo}}
  \\
}

% Main content: This appears either once or twice, controlled by
% \twosetsperpage.
\newcommand\content{
  \header
  \smallbreak
  \theregister
}

% Print register on one or two pages. Option is provided as class option.
\newcommand\makecontent{
  \ifdefined\@twosets
    \begin{minipage}[t][0.5\paperheight][t]{\textwidth}
      \content
    \end{minipage}
    \begin{minipage}[t][0.4\paperheight][t]{\textwidth}
      \content
    \end{minipage}
  \else
      \content
  \fi
}
