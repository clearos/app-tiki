
Name: app-tiki
Epoch: 1
Version: 1.6.1
Release: 1%{dist}
Summary: Tiki Wiki CMS Groupware
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-webapp
Requires: app-system-database >= 1:1.5.30

%description
Tiki Wiki CMS Groupware is a free and open source wiki-based, content management system and online office suite.

%package core
Summary: Tiki Wiki CMS Groupware - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-webapp-core
Requires: app-system-database-core >= 1:1.5.30
Requires: webapp-tiki

%description core
Tiki Wiki CMS Groupware is a free and open source wiki-based, content management system and online office suite.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/tiki
cp -r * %{buildroot}/usr/clearos/apps/tiki/

install -d -m 0755 %{buildroot}/var/clearos/tiki
install -d -m 0755 %{buildroot}/var/clearos/tiki/archive
install -d -m 0755 %{buildroot}/var/clearos/tiki/backup
install -D -m 0644 packaging/webapp-tiki-flexshare.conf %{buildroot}/etc/clearos/flexshare.d/webapp-tiki.conf
install -D -m 0644 packaging/webapp-tiki-httpd.conf %{buildroot}/etc/httpd/conf.d/webapp-tiki.conf

%post
logger -p local6.notice -t installer 'app-tiki - installing'

%post core
logger -p local6.notice -t installer 'app-tiki-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/tiki/deploy/install ] && /usr/clearos/apps/tiki/deploy/install
fi

[ -x /usr/clearos/apps/tiki/deploy/upgrade ] && /usr/clearos/apps/tiki/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-tiki - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-tiki-core - uninstalling'
    [ -x /usr/clearos/apps/tiki/deploy/uninstall ] && /usr/clearos/apps/tiki/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/tiki/controllers
/usr/clearos/apps/tiki/htdocs

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/tiki/packaging
%dir /usr/clearos/apps/tiki
%dir /var/clearos/tiki
%dir /var/clearos/tiki/archive
%dir /var/clearos/tiki/backup
/usr/clearos/apps/tiki/deploy
/usr/clearos/apps/tiki/language
/usr/clearos/apps/tiki/libraries
%config(noreplace) /etc/clearos/flexshare.d/webapp-tiki.conf
%config(noreplace) /etc/httpd/conf.d/webapp-tiki.conf
