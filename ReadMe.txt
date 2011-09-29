{\rtf1\ansi\ansicpg1252\cocoartf1038\cocoasubrtf360
{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww9000\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\ql\qnatural\pardirnatural

\f0\fs24 \cf0 === GitSwitch ===\
Contributors: Jasper Valero (GitHub: jaspervalero)\
Tags: github, pivotaltracker, bugs, issues\
Requires GitHub API v2\
Version: 0.8\
\
GitSwitch is a PHP script that allows issues from a GitHub repository to be imported directly into PivotalTracker using a custom import panel.\
\
== Description ==\
\
I coded GitSwitch after getting involved with an open source project that was using PivotalTracker and a GitHub repository for a VCS. The project team was looking for a way to pull GitHub issues into PivotalTracker without having to manually input each bug received. After doing some research I found out that PivotalTracker did not offer built-in support for GitHub despite its growing popularity.\
\
So I did some checking around and I found a few scripts, some dated and others were a bit more than what we wanted and didn't offer support for importing issues. There was nothing that met the projects needs. So that is where GitSwitch comes in. I wrote it initially for the open source project that I am working on. After testing it out, I decided to rewrite the code to a more reusable friendly format and make the script public so that others who may be looking for a similar solution could take advantage of it.\
\
Although PivotalTracker doesn't offer built in support for GitHub, it does offer custom panels for importing XML data. GitSwitch pulls JSON data from GitHub's Issues API and converts it into XML formatted for input into PivotalTracker. So by installing GitSwitch you will get a built in panel inside of Pivotal Tracker that will allow you to pull in issues directly from your GitHub repo.\
\
GitSwitch offers three import modes:\
* List Mode - Pulls in all "open" or "closed" issues\
* Label Mode - Pulls in issues that have a certain label\
* Search Mode - Searches for and pulls in issues with a certain keyword\
\
== Installation ==\
\
Installing GitSwitch is very easy to do. Even if you don't know PHP at all you can still set it up and have it working in about 2-3 minutes. All you have to do is edit a few settings to point to your project's repo and select an import mode. The script is well commented to help you along the way.\
\
= Script Setup =\
\
1. Open GitSwitch.php in your favorite text editor.\
2. Find the properties section which begins on line 57.\
3. Enter the username of the person who owns the GitHub repo in between the "" next to $username. This would be :user portion of the following URL: https://github.com/:user/:repo\
4. Enter the repo name of the project you want to import issues from in between the "" next to $repo. This would be :repo portion of the following URL: https://github.com/:user/:repo\
5. Enter the name that you want to show up as the requester in your PivotalTracker stories in between the "" next to $requester. Ideally this will mirror the name of accounts associated with your project in PivotalTracker.\
6. Leave $state set to it's default "open" unless you want to import closed issues from your GitHub repo. For most situations this would not be the case.\
7. Next you will need to choose the import mode that you want to use. If you are working with a team you may want to discuss the best option for your project and agree on a mode before you go any further. Once you know which mode you want to use set $mode equal "list" (List Mode), "label" (Label Mode), "search" (Search Mode). Please note that if you want to use list mode you won't have to do anything as it is the default mode.\
8. If you chose List Mode then you are done modifying the script and you can save it. If you chose the Label mode then you will need to enter the case-sensitive label between the "" next to $label and save it. If you chose Search Mode then you will need to enter the keyword that you want to search for in between the "" next to $keyword and save it.\
9. Regardless of which mode you chose, you are now ready to upload GitSwitch.php to your hosting account/server that is PHP enabled. It can be uploaded to any location on your server so long as it can be read from the web.\
10. Once it is uploaded navigate to the URL of the location you uploaded it to. If you get errors then make sure to double check the values you entered in the steps above. If you see XML displaying in your browser than you are ready to move onto the next part of the installation below.\
\
= PivotalTracker Integration =\
\
1. Make sure you have "Owner" rights to the PivotalTracker project you want to integrate the script with.\
2. Click on the drop down menu "Project" at the top of your PivotalTracker project and select "Configure Integrations".\
3. Scroll to the bottom of the new page until you see "External Tool Integrations" section.\
4. Click on the drop down menu to the right that says "Create New Integration" and select "Other".\
5. On the next screen enter a "Name" for the integration. This will be the name of the panel used to pull in issues inside of PivotalTracker. e.g. GitSwitch, Bugs, Issues, etc.\
6. Leave "Basic Auth Username" and "New Basic Auth Password" blank.\
7. For "Base URL" you will want to enter the url to your GitHub issues page. You can copy/paste this from your browser or use the following format example: https://github.com/:user/:repo/issues.\
8. Check the box next to "Active?" and click Save. The script is now installed and ready to test.\
\
= Testing =\
\
1. Go to your GitHub repo and create an issue and name it "Test GitSwitch". If you are using Label or Search mode make sure you add the same label you set the script to look for or include the keyword that you asked it to search for in the description.\
2. Now go back to your PivotalTracker project and click on the "More" drop down and toward the bottom you should see the name that you gave the panel. Select it. This will open up the panel inside your PivotalTracker view and automatically import your test issue and any other issues that meet the criteria of the settings you entered in the script. If you see the "Test GitSwitch" issue then you are ready to go. Just open the panel when you want to use it or leave it open and click refresh when you want to check for new issues. You can then drag and drop them from the panel into the other panels in your project. If for some reason you do not see your test issue than go back and check your script settings and check the labels and keywords and status of your test issue to make sure they meet the criteria that you set in GitSwitch.\
\
== Frequently Asked Questions ==\
\
= Does GitSwitch reflect updates/modifications/changes back out to GitHub? =\
\
No, in the current version it is only one way. GitHub --> PivotalTracker. If there is enough interest I may look at adding additional features and functionality.\
\
= How can I request additional features/functionality? =\
\
Create and issue or comment on an existing one in the GitSwitch repo if you wish to let me know about features you would like to see added. I can't promise they will get done, but if there is enough interest or I have enough time I will do my best.\
\
= Can I customize this script for my projects unique needs? =\
\
Yes, feel free to customize, modify or update the script if you'd like to make it do something it doesn't currently do. All I ask is that if you use any portion of my code that you attribute that portion to me.\
\
== Changelog ==\
\
= 0.8 =\
9/29/11\
* Cleaned up code and added more comments for clarification\
* Removed hard coding and added properties to allow for quicker and easier reuse\
* Added two additional import modes: Label and Search (for a total of 3 including List)\
* Added ReadMe.txt with installation instructions}