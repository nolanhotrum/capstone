<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dog's Way</title>
    <style>
        /* Theming */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap");
        /* import font */

        :root {
            --white: #f9f9f9;
            --black: #36383F;
            --gray: #85888C;
            --green: #5F9EA0;
            --darker-green: #4F8A93;
            --border-color: #4F8A93;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--white);
            font-family: "Poppins", sans-serif;
        }

        a {
            text-decoration: none;
        }

        ul {
            list-style: none;
        }

        /* Header */
        .header {
            background-color: var(--black);
            box-shadow: 1px 1px 5px 0px var(--gray);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header-content {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            background: var(--green);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 40px;
            margin-right: 10px;
        }

        .logo img {
            width: 100%;
        }

        .longName,
        .shortName {
            color: #fff;
            font-size: 24px;
        }

        .longName {
            display: inline-block;
        }

        .shortName {
            display: none;
        }

        .nav {
            margin-left: 20px;
            display: flex;
        }

        nav ul {
            display: flex;
        }

        nav ul li {
            margin-right: 15px;
        }

        nav ul li a {
            color: #fff;
            font-size: 18px;
            padding: 5px 10px;
            transition: 0.2s;
            display: block;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            margin-bottom: 5px;
        }

        nav ul li a:hover,
        nav ul li a.active {
            color: #4ad295;
            background-color: var(--darker-green);
            border-color: var(--green);
        }

        .hamburger {
            display: none;
            margin-left: 20px;
            cursor: pointer;
        }

        .hamburger .hamburger-line {
            background: var(--white);
            display: block;
            height: 2px;
            position: relative;
            width: 24px;
        }

        .hamburger .hamburger-line::before,
        .hamburger .hamburger-line::after {
            background: var(--white);
            content: '';
            display: block;
            height: 100%;
            position: absolute;
            transition: all .2s ease-out;
            width: 100%;
        }

        .hamburger .hamburger-line::before {
            top: 5px;
        }

        .hamburger .hamburger-line::after {
            top: -5px;
        }

        /* Media query for smaller screens */
        @media only screen and (max-width: 1000px) {
            .header-content {
                padding: 0 10px;
            }

            .longName {
                display: none;
            }

            .shortName {
                display: inline-block;
            }

            .nav {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                height: auto;
                background-color: var(--green);
                z-index: 1;
                overflow: hidden;
                transition: height 0.5s ease-out;
            }

            .menu {
                display: flex;
                flex-direction: column;
                width: 100%;
                padding-top: 20px;
            }

            .hamburger {
                display: flex;
            }

            .menu a {
                padding: 15px;
                text-align: center;
                color: var(--white);
                display: block;
                border: 1px solid var(--border-color);
                border-radius: 5px;
                margin-bottom: 5px;
            }

            .menu a:hover {
                background-color: var(--darker-green);
                border-color: var(--green);
            }

            .hamburger .hamburger-line {
                background: transparent;
            }

            .side-menu:checked~.nav {
                display: flex;
                height: 500px !important;
            }

            .side-menu:checked~.hamburger .hamburger-line::before {
                transform: rotate(-45deg);
                top: 0;
            }

            .side-menu:checked~.hamburger .hamburger-line::after {
                transform: rotate(45deg);
                top: 0;
            }
        }
    </style>
</head>