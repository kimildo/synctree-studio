# Synctree Studio

## 기본정책
> 1. 앱이 가장 큰단위
> 2. 비즈유닛은 앱에 속한다. 비즈유닛간의 연계성은 없다.
> 3. 오퍼레이터는 통신의 기본단위 개념이다. 팀에 속하며 비즈유닛에 바인딩 시킬 수 있다.
> 4. 앱, 비즈유닛, 오퍼레이터의 정보값은 DB에 있고, 이를 조합해 Redis에 메타데이터를 생성해 갖고 있다.

## 개발 완료된 기능
> - 비즈유닛에 오퍼레이터를 바인딩하고 오퍼레이터 간의 변수 연계 지원
> - 오퍼레이터 JSON 형식 지원
> - 오퍼레이터 보안프로토콜 적용
> - ALT 컨트롤 기능 (오퍼레이터 switch case)
> - 오퍼레이터 Asyc 기능 (예정)
